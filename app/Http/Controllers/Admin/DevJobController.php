<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\DevJob;
use DB;

class DevJobController extends Controller
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
          
            $data = DevJob::select('id', 'job_id', 'company_name', 'title', 'city', 'date', 'job_position', 'dev_exp', 'employment_type', 'is_open', 'promoted', 'full_description')->withCount([ 'buttonClicked' , 'jobTitleClicked' ])->when(($request->is_opened != '0'), function($q) use($request) {
                    return $q->where("is_open", 1);
                })->when(($request->yearsExperience != ''), function($q) use($request) {
                    return $q->where("dev_exp", $request->yearsExperience );
                })->when(($startDate != '' && $endDate != ''), function($q) use($startDate, $endDate)  {
                    return $q->whereBetween("date", [ date("Y-m-d", strtotime($startDate)), date("Y-m-d", strtotime($endDate)) ]);
                });
                
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<button class="edit btn btn-primary btn-sm edit-job mr-2" ><i class="fa fas fa-edit" data-jobid="'.$row->job_id.'"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.jobs.index');
    }
    public function yearsExperience(Request $request) {
        if ($request->ajax()) {
            $data = DevJob::select('exp_desc', DB::raw("count(*) as count"))->groupBy("exp_desc")->whereNotNull("exp_desc");
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<button class="edit btn btn-primary btn-sm edit-job-exp mr-2" ><i class="fa fas fa-edit"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('admin.jobs.years_of_experience');
    }

    public function update(Request $request) {

        $validatedData =  $request->validate([
            'job_id' => 'required',
            'is_open' => 'required',
            'title' => 'required',
            'full_description' => 'required',
            'promoted' => 'nullable',
            're_generate' => 'nullable',
        ]);
        DevJob::where("job_id", $validatedData["job_id"])->update([
            "is_open" => $validatedData["is_open"],
            "title" => $validatedData["title"],
            "full_description" => $validatedData["full_description"],
            "promoted" => isset($validatedData["promoted"])?$validatedData["promoted"]:0,
        ]);
        if(isset($validatedData["re_generate"]) && $validatedData["re_generate"] == '1') {
            
            \Artisan::call('app:re-generate-dev-job --jobId='.$validatedData["job_id"]);

        }
        return response()->json([ 'message' => 'Jobs updated successfully'  ]);
    }
}
