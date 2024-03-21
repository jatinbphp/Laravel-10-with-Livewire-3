<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Models\Company;
use App\Models\DevJob;
use Goutte\Client;
use DOMDocument;
use DOMXPath;
use App\Jobs\FetchCompanyJobs;
use App\Models\ManuallyJob;
use DB;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{

    public function index(Request $request) {

        if ($request->ajax()) {
            $startDate = '';
            $endDate = '';
            if($request->date != '') {
                $explode = explode("-", $request->date);
                $startDate = date("Y-m-d", strtotime(trim($explode[0])));
                $endDate = date("Y-m-d", strtotime(trim($explode[1])));
            }
            
            $data = Company::select('id', 'name', 'is_closed', 'company_id', 'linkedin_id','re_run_jobs', 'total_dev_jobs')->withCount([ 'buttonClicked' => function ($query) use($startDate, $endDate) {
                        $query->when(($startDate != '' && $endDate != ''), function ($q) use ($startDate, $endDate) {
                            return $q->select(DB::raw('COUNT(DISTINCT CONCAT(user_id, job_id))'))->whereBetween("created_at", [date("Y-m-d", strtotime($startDate)), date("Y-m-d", strtotime($endDate))]);
                        });
                    }, 'jobTitleClicked' => function ($query) use($startDate, $endDate) {
                        $query->when(($startDate != '' && $endDate != ''), function($q) use($startDate, $endDate)  {
                            return $q->whereBetween("created_at", [ date("Y-m-d", strtotime($startDate)), date("Y-m-d", strtotime($endDate)) ]);
                        });
                    }, 'devJobs' ]);
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mr-2 edit-company" data-id="'.$row->id.'" ><i class="fa fas fa-edit"></i></a>';
                        $btn .= " <a href='javascript:void(0)'  class='edit btn btn-primary btn-sm mr-2 deleteCompany' data-id='".$row->id."'><i class='fa fas fa-trash'></i></a>";
                        if($row->linkedin_id != '') {
                            $btn .= " <a href='javascript:void(0)' class='edit btn btn-primary btn-sm mr-2 re-run-company ".(($row->re_run_jobs != 0)?' disabled':'')."' data-id='".$row->id."'><i class='fa fas fa-sync fa-lg'></i></a>";
                        } else {
                            $btn .= " <a href='javascript:void(0)' class='edit btn btn-primary btn-sm mr-2 add-job-company ' data-id='".$row->id."' title='Add Jobs'><i class='fa fas fa-plus fa-lg'></i></a>";
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $cities = DevJob::select('city')->where('city', "!=",'')->where('is_open', 1)->groupBy('city')->orderBy('city', 'asc')->pluck('city');
        return view('admin.company.index', compact('cities'));
    }
    
    public function fetchLinkedInDetail(Request $request) {
        $request->validate([
            'linkedin_id' => 'required|unique:companies,linkedin_id',
            'linkedin_session' => 'required',
        ]);
        
       
        $opts = array('http' => array('header'=> "Cookie: li_at=".$request->linkedin_session."\r\n"));
        $context = stream_context_create($opts);
        $contents = file_get_contents("https://www.linkedin.com/company/".$request->linkedin_id."/about", true, $context);
        $companyData = [];
        $companyData['logo_url'] = '';
        $companyData['employees_number'] = '';
        if($contents != '') {
            $doc = new DOMDocument();
            @$doc->loadHTML($contents);
            $xpath = new DOMXPath($doc);
            $codeObjects =  $xpath->evaluate('//code');
            foreach($codeObjects as $codeObject) {
                $jsonData = json_decode($codeObject->nodeValue);
                if(isset($jsonData->included)) {

                    foreach ($jsonData->included as $key => $linkedInObj) {
                        if (isset($linkedInObj->preDashEntityUrn) && $linkedInObj->preDashEntityUrn == "urn:li:fs_normalized_company:".$request->linkedin_id ) {                        
                            $companyData['name'] = @$linkedInObj->name;
                            $companyData['description'] = @$linkedInObj->tagline;
                            $companyData['about'] = @$linkedInObj->description;
                            $companyData['websiteUrl'] = @$linkedInObj->websiteUrl;
                            if(isset($linkedInObj->{'*industryV2Taxonomy'})) {
                                $primary_sector = $linkedInObj->{'*industryV2Taxonomy'};
                                
                                foreach ($jsonData->included as $key => $subLinkedInObj) {
                                    if(isset($subLinkedInObj->entityUrn) && $subLinkedInObj->entityUrn == $primary_sector[0]) {
                                        $companyData['primary_sector'] = $subLinkedInObj->name;
                                        break;
                                    }
                                }
                            }
                            if (isset($linkedInObj->crunchbaseFundingData)) {
                                $companyData['last_round'] = $linkedInObj->crunchbaseFundingData->lastFundingRound->localizedFundingType;
                                $companyData['total_funding'] = '';
                                if(isset($linkedInObj->crunchbaseFundingData->lastFundingRound->moneyRaised->currencyCode)) {
                                    $companyData['total_funding'] = $linkedInObj->crunchbaseFundingData->lastFundingRound->moneyRaised->currencyCode.' '.$linkedInObj->crunchbaseFundingData->lastFundingRound->moneyRaised->amount;
                                }
                            }
                            if (isset($linkedInObj->employeeCountRange)) {
                                $companyData['employees_number'] = $linkedInObj->employeeCountRange->start.(($linkedInObj->employeeCountRange->end != null)? "-".$linkedInObj->employeeCountRange->end : "");
                            }
                            if (isset($linkedInObj->groupedLocations)) {
                                if (isset($linkedInObj->groupedLocations[0]->locations)) {
                                    $companyData['city'] = $linkedInObj->groupedLocations[0]->locations[0]->address->city;
                                    
                                    $companyData['address'] = $linkedInObj->groupedLocations[0]->locations[0]->address->line1.(($linkedInObj->groupedLocations[0]->locations[0]->address->line1 != '')?", ":"").$linkedInObj->groupedLocations[0]->locations[0]->address->city.', Israel';
                                }
                            }
                            if (isset($linkedInObj->logoResolutionResult) && $companyData['logo_url'] == '') {

                                $companyData['logo_url'] = $linkedInObj->logoResolutionResult->vectorImage->rootUrl.$linkedInObj->logoResolutionResult->vectorImage->artifacts[0]->fileIdentifyingUrlPathSegment;
                            }
                            if (isset($linkedInObj->foundedOn)) {
                                $companyData['founded'] = $linkedInObj->foundedOn->year;
                            }
                        }
                        
                        
                    }
                }
            }

        }

        return response()->json($companyData);
    }
    public function store(Request $request) {
        $validateData = $request->validate([
            'name' => 'required',
            'linkedin_id' => (($request->company_id =='')?['nullable',Rule::unique('companies')->where(function ($query) {
                return $query->whereNotNull('linkedin_id')->where("linkedin_id", "!=", '');
            })]:['nullable', Rule::unique('companies')->where(function ($query)  use($request) {
                return $query->whereNotNull('linkedin_id')->where("linkedin_id", "!=", '')->where("company_id", "!=", $request->company_id);
            })]),
            'description' => 'required',
            'about' => 'required',
            'website_url' => 'required|url',
            'logo_url' => 'required|url',
            'primary_sector' => 'required',
            'founded' => 'required',
            'address' => 'required',
            'city' => 'required',
            'employees' => 'required',
            'funding_stage' => 'required',
            'total_funding' => 'nullable',
            'type' => 'required',
            'email_address' => 'nullable',
        ]);
        $companyData = [
                'israel_since' => (($request->israel_since != '')?$request->israel_since:null),
                'careers_url' => "https://www.linkedin.com/company/".$request->linkedin_id."/jobs",
            ];   
        if($request->company_id == '') {
            $companyData['company_id'] = createSlug($request->name);
            $companyData['re_run_jobs'] = 1;
                 
            $company = Company::create(array_merge( $validateData, $companyData));
            dispatch(new FetchCompanyJobs($company->id));
            $message = 'Company created successfully';
        } else {
              
            $company = Company::where('company_id', $request->company_id)->update(array_merge( $validateData, $companyData));
            $message = 'Company updated successfully';
        }
 
        return response()->json([ 'company' => $company, 'message' => $message ]);
    }
    public function manuallyJobCreate(Request $request) {
        $validateData = $request->validate([
            'company_id' => 'required',
            'company_name' => 'nullable',
            'job_type' => 'required',
            'title' => 'required',
            'city' => 'required',
            'employment_type' => 'required',
            'full_description' => 'required'
        ]);
        $job = ManuallyJob::create($validateData);

        $message = 'Jobs created successfully';
        return response()->json([ 'job' => $job, 'message' => $message  ]);
    }
    public function resync(Request $request)
    {
        $company = Company::find($request->company_id);
        if(empty($company)) {
            abort(404);
        } else {
            $company->re_run_jobs = 1;
            $company->save();
            dispatch(new FetchCompanyJobs($company->id));
        }
        return true;
    }
    public function details($companyId)
    {
        $company = Company::select( 'name')->where('company_id', $companyId)->first();
        return view('company_details', compact('companyId', 'company'));
    }
    public function delete(Company $company)
    {
        $company->delete();
        return response()->json([ 'message' => 'Company deleted successfully.' ]);
    }
    public function show(Company $company)
    {
        return response()->json([ 'company' => $company ]);
    }
    public function allCompanies()
    {
        return response()->json([ 'companies' => Company::all() ]);
    }
}
