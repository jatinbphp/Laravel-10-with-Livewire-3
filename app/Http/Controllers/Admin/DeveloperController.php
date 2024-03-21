<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\JobsMissCompany;
use App\Models\Developer;
use App\Models\Skill;
use App\Models\SkillNotFound;
use App\Models\DeveloperSkill;
use App\Models\Setting;
use App\Models\IgnoreMissingJobsCompany;
use DB;
use \ConvertApi\ConvertApi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Auth;
class DeveloperController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Developer::select('id', 'user_id', 'first_name', 'last_name', 'city', 'email', 'phone' , 'developer_type' , 'dev_experience' , 'bsc' , 'idf', 'filename', 'phone_verified', 'email_verified' )->withCount('developerSkills');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mr-2 mb-2 " data-id="'.$row->id.'" ><i class="fa fas fa-edit"></i></a>';
                        $btn .= " <a href='javascript:void(0)'  class=' btn btn-primary btn-sm mr-2 mb-2 delete-developer' data-id='".$row->id."'><i class='fa fas fa-trash'></i></a>";
                        $btn .= " <a href='".route("admin.developer.download", [ $row->filename ])."'  class=' btn btn-primary btn-sm mr-2 mb-2 ' ><i class='fa fas fa-download'></i></a>";
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.developer.index');
    }
    public function download($filename)
    {
        if (Storage::disk('public')->exists("developers/".$filename)) {
            
            $path = Storage::disk('public')->path("developers/".$filename);

            return response()->download($path, $filename);
        } else {
            abort(404);
        }
    }
    function createDeveloper($aiResponse, $aiResponseData, $CVcontent) {
        $profileImage = generateRandomProfileAvatar();
        return Developer::create([
                "first_name" => $aiResponse->First,
                "last_name" => $aiResponse->Last,
                "dob" => ($aiResponse->DOB == '')?null:date("Y-m-d", strtotime($aiResponse->DOB)),
                "city" => $aiResponse->City,
                "phone" => str_replace([ "-", "+972"," "], ["", "0", ""], $aiResponse->Phone),
                "email" => $aiResponse->Email,
                "email_verified" => ((Auth::check())?((Auth::user()->email == $aiResponse->Email && (Auth::user()->google_id != '' || Auth::user()->email_verified_at != ''))?date("Y-m-d H:i:s"):null):null),
                "profile_image" => $profileImage,
                "bsc" => $aiResponse->BSC,
                "idf" => getIDFColumnValue($aiResponse->IDF),
                "developer_type" => $aiResponse->DeveloperType,
                "dev_experience" => $aiResponse->DevExperience,
                "manager_exp" => (($aiResponse->ManagerExp == 'true' || $aiResponse->ManagerExp === true)?1:0),
                "title" => $aiResponse->Title,
                "description" => $aiResponse->Bio,
                "cv_content" => $CVcontent,
                "ai_response" => $aiResponseData,
                "education" => implode(";", $aiResponse->Education),
                "softskills" => implode(";", $aiResponse->SoftSkills),
                "logged_user_id" => ((Auth::check())?((Auth::user()->type == 1)?Auth::id():null):null)
            ]);
    }
    function updateDeveloper($aiResponse, $aiResponseData, $CVcontent, $developer) {
        $phone = str_replace([ "-", "+972"," "], ["", "0", ""], $aiResponse->Phone);
        $developer->first_name = $aiResponse->First;
        $developer->last_name = $aiResponse->Last;
        $developer->dob = ($aiResponse->DOB == '')?null:date("Y-m-d", strtotime($aiResponse->DOB));
        $developer->city = $aiResponse->City;
        $developer->phone_verified = (($developer->phone == $phone && $developer->phone_verified != '')?date("Y-m-d H:i:s"):null);
        $developer->phone =$phone ;
        $developer->email_verified = ((Auth::check())?(((Auth::user()->email == $aiResponse->Email && (Auth::user()->google_id != '' || Auth::user()->email_verified_at != '')) || ($developer->email == $aiResponse->Email && $developer->email_verified != ''))?date("Y-m-d H:i:s"):null):null);
        $developer->email = $aiResponse->Email;

        $developer->bsc = $aiResponse->BSC;
        $developer->idf = getIDFColumnValue($aiResponse->IDF);
        $developer->developer_type = $aiResponse->DeveloperType;
        $developer->dev_experience = $aiResponse->DevExperience;
        $developer->manager_exp = (($aiResponse->ManagerExp == 'true' || $aiResponse->ManagerExp === true)?1:0);
        $developer->title = $aiResponse->Title;
        $developer->description = $aiResponse->Bio;
        $developer->cv_content = $CVcontent;
        $developer->ai_response = $aiResponseData;
        $developer->education = implode(";", $aiResponse->Education);
        $developer->softskills = implode(";", $aiResponse->SoftSkills);
        $developer->save();
        return $developer;
        
    }
    public function add(Request $request) {
        $request->validate([
            'content' => 'required',
        ]);
        $settings = Setting::select('value')->where("key", "ExtractDeveloperCVAndSkillsPrompt")->orderBy("id","asc")->first();
        $prompt =  [ [ "role" => "system", "content" => $settings->value ], [ "role" => "user", "content" => $request->content ]];
        $aiResponseData = azureOpenAI($prompt);
        $aiResponse = json_decode($aiResponseData);
        // dd($aiResponse);
        
        if($aiResponse->DeveloperType == "Not Developer") {
            unlink(storage_path('/app/public/developers/'.$request->filename));
            return response()->json([ "not_developer" => $aiResponse->DeveloperType ]);
        } else {
            if(Auth::check() && Auth::user()->type == 1) {
                $developer = Developer::where('logged_user_id', Auth::id())->first();
                if(!empty($developer)) {
                    $developer = $this->updateDeveloper($aiResponse, $aiResponseData, $request->content, $developer);
                    if($developer) {
                       // $developer = Developer::where("logged_user_id", Auth::id())->first();
                        DeveloperSkill::where( "developer_id", $developer->id )->delete();
                    } else {
                        return response()->json([ "developer" => $developer ], 404);
                    }
                } else {
                    $developer = $this->createDeveloper($aiResponse, $aiResponseData, $request->content);
                    generateSiteMap([ route('developer_details',[ $developer->user_id ]) ], []);
                }
            } else {
                $developer = $this->createDeveloper($aiResponse, $aiResponseData, $request->content);
                generateSiteMap([ route('developer_details',[ $developer->user_id ]) ], []);
            }
            
            foreach ($aiResponse->JobPositions as $jobPosition) {
                $yearsExp = (isset($jobPosition->YOE)?$jobPosition->YOE:null);
                foreach ($jobPosition->Skills as $skill) {
                    $this->createDeveloperSkill( $developer, $skill, $yearsExp);
                    
                }
            }
            foreach ($aiResponse->TechSkills as $techSkill) {
                $this->createDeveloperSkill( $developer, $techSkill, 0);
            }
            if($request->filename != '') {
                $fileExtension = File::extension($request->filename);
                
                $filename = $developer->user_id."-CV.".$fileExtension;
             
                $oldFilePath = storage_path('app/public/developers/' . $request->filename);
                $newFilePath = storage_path('app/public/developers/' . $filename);
                // Check if the file exists before moving
                if (File::exists($oldFilePath)) {
                    // Move the file
                    $developer->filename = $filename;
                    $developer->save();
                    File::move($oldFilePath, $newFilePath);
                }
            }
            return response()->json([ "developer" => $developer ]);
        }
        
    }
    public function createDeveloperSkill( $developer, $skill, $yearsExp) {
        $skillData = Skill::select("category_id", "name", "display_name")->where('name', '='  , trim($skill))->first();
        if(isset($skillData->category_id)) {
            $category_id = $skillData->category_id;
            $skillName = $skillData->display_name;
            $this->insertOrUpdateSkill($developer, $skillName, $yearsExp, $category_id);
        } else {
            $skillExplodeArray = $this->multiexplode(["/"," /", " or "," (",") "," [","] ", ","], str_replace([ "TCP/IP","TCP / IP", "CI/CD","CI / CD", "L2/L3","e.g."], ["TCP__IP", "TCP__IP", "CI__CD", "CI__CD", "L2__L3", "" ], trim($skill)));
            $checkSkillExist = false;
            foreach ($skillExplodeArray as $skillExplode) {
                if(substr(trim($skillExplode), -1) == ")" && stripos($skillExplode, "(") === false) {
                    $skillName = substr_replace(trim($skillExplode),"",-1);
                } elseif(substr(trim($skillExplode), -1) == "]" && stripos($skillExplode, "[") === false) {
                    $skillName = substr_replace(trim($skillExplode),"",-1);
                } else {
                    $skillName = trim($skillExplode);
                }
                $skillName = str_replace([ "TCP__IP", "CI__CD", "L2__L3" ], [ "TCP/IP", "CI/CD", "L2/L3"], $skillName );
                if(strtolower($skillName) != "etc.") {
                    $skillData = Skill::select("category_id" )->where('name', '='  , $skillName)->first();
                    if(isset($skillData->category_id)) {
                        $checkSkillExist = true;
                        break;
                    }
                }
            }
            if($checkSkillExist) {
                foreach ($skillExplodeArray as $skillExplode) {
                    if(substr(trim($skillExplode), -1) == ")" && stripos($skillExplode, "(") === false) {
                        $skillName = substr_replace(trim($skillExplode),"",-1);
                    } elseif(substr(trim($skillExplode), -1) == "]" && stripos($skillExplode, "[") === false) {
                        $skillName = substr_replace(trim($skillExplode),"",-1);
                    } else {
                        $skillName = trim($skillExplode);
                    }
                    $skillName = str_replace([ "TCP__IP", "CI__CD", "L2__L3" ], [ "TCP/IP", "CI/CD", "L2/L3"], $skillName );
                    $skillData = Skill::select("category_id", "display_name" )->where('name', '='  , $skillName)->first();
                    if(isset($skillData->category_id)) {
                        $this->insertOrUpdateSkill($developer, $skillData->display_name, $yearsExp, $skillData->category_id);
                    } else {
                        $this->insertOrUpdateSkill($developer, $skillName, $yearsExp, 12);
                    }
                }
            } else {
                $skillName = trim($skill);
                $this->insertOrUpdateSkill($developer, $skillName, $yearsExp, 12);
            }
        }
        
    }

    function insertOrUpdateSkill($developer, $skillName, $yearsExp, $category_id) {
        if(!DeveloperSkill::where("skill_name", $skillName)->where("developer_id", $developer->id)->exists()) {
                DeveloperSkill::create([
                    "developer_id" => $developer->id,
                    "skill_name" => $skillName,
                    "category_id" => $category_id,
                    "years_exp" => $yearsExp,
                ]);
            } elseif($yearsExp > 0) {
                $developerSkill = DeveloperSkill::select("years_exp")->where("developer_id" , $developer->id)->where("skill_name", $skillName)->first();
                DeveloperSkill::where("developer_id" , $developer->id)->where("skill_name", $skillName)->update([
                    "years_exp" => ($developerSkill->years_exp + $yearsExp)
                ]);
            }
    }
    function multiexplode($delimiters,$string) {

        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  array_filter($launch);
    }
    public function uploadFileReadData(Request $request)
    {
               
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx',
        ]);
        $data = $request->all();
        $content = '';
        if ($request->hasFile('file')) {
            ConvertApi::setApiSecret(env("CONVERT_API_KEY"));
            $file = $request->file;
            $fileExtension       = $request->file->extension();
            $name            = $file->getClientOriginalName();
            $destinationPath = storage_path('/app/public/developers/');
            $file->move($destinationPath, $name);

            if($fileExtension == 'pdf') {
                
                $result = ConvertApi::convert('txt', [
                        'File' => $destinationPath.''.$name,
                    ], 'pdf'
                );
                $content = $result->getFile()->getContents();
                

            } else {
               
                $result = ConvertApi::convert('html', [
                        'File' => $destinationPath.''.$name,
                    ], $fileExtension
                );
                
                preg_match("/<body.*\/body>/s", $result->getFile()->getContents(), $matches);
                $html = new \Html2Text\Html2Text($matches[0]);
               
                $content = trim($html->getText());
                $pattern = '/\n+/';
                $replacement = "\n";
                $content = preg_replace($pattern, $replacement, $content);
                
            }
          
        }
        return response()->json([ "filename" => $name, "content" => $content ]);
       
    }    
    public function delete(Developer $developer) {
        DeveloperSkill::where("developer_id", $developer->id)->delete();
        generateSiteMap([], [ route('developer_details',[ $developer->user_id ]) ]);
        $developer->delete();
        return response()->json(['message' => 'Developer deleted successfully']);
    }
}
