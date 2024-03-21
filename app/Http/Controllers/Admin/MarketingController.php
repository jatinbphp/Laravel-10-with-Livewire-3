<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marketing;
use DataTables;
use DB;
use Twilio\Rest\Client;


class MarketingController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            
            $data = Marketing::select('id',"name", "image", "content", "query", "phone");
            
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mr-1 mb-1 generate-marketing-response" data-id="'.$row->id.'" >Generate</a>';
                        $btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mr-1 mb-1 edit-marketing" data-id="'.$row->id.'" ><i class="fa fas fa-edit"></i></a>';
                        $btn .= " <a href='javascript:void(0)'  class='edit btn btn-primary btn-sm mr-1 mb-1 delete-marketing' data-id='".$row->id."'><i class='fa fas fa-trash'></i></a>";
                       $btn .= '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm mr-1 mb-1 send-marketing-response" data-id="'.$row->id.'" >Send</a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.marketing.index');
    }
    public function store(Request $request) {
        $validateData = $request->validate([
            'image' => 'required_without:id|file|mimes:jpg,png,jpeg,gif',
            'name' => 'required',
            'content' => 'required',
            'query' => 'nullable',
            'phone' => 'nullable',
        ], ['image.required_without' => "The image field is required."]);
        if ($request->hasFile('image')) {
            
            $file = $request->image;
            $fileExtension       = $request->image->extension();
            $filename            = $file->getClientOriginalName();
            $destinationPath = storage_path('/app/public/marketings/');
            $file->move($destinationPath, $filename);
            $validateData['image'] = $filename;
        } else {
            unset($validateData['image']);
        }
        if($request->id == '') {
            $company = Marketing::create($validateData);
            $message = 'Marketing created successfully';
        } else {
              
            $company = Marketing::where('id', $request->id)->update($validateData);
            $message = 'Marketing updated successfully';
        }
 
        return response()->json([ 'company' => $company, 'message' => $message ]);
    }
    public function send( Request $request)
    {
        $validateData = $request->validate([
            'marketingValues' => 'required',
        ]);
        $messageSid = [];
        foreach (explode(",", $request->marketingValues) as $marketingId) {
            $marketing = Marketing::find($marketingId);
            if(!empty($marketing)) {
                $devJobs = [];
                if($marketing->query != '') {
                    
                    $devJobs = DB::select($marketing->query);
                }
                $devJobsResult = '';
                foreach ($devJobs as $key => $devJob) {
                    $devJobsResult .="\n ".$devJob->title." - ".$devJob->company_name.", ".$devJob->city." \n ".route("job_details",[$devJob->job_id])."\n ";
                    if($key >= 4) {
                        break;
                    }
                }
                $marketing->content = str_replace("[DATA RESPONSE FROM QUERY]", $devJobsResult, $marketing->content);
                $to = "+".$marketing->phone; 
                $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
                
                foreach (explode(",", $marketing->phone) as $phone) {
                    $message = $twilio->messages
                    ->create("whatsapp:+".trim($phone), 
                        [
                            'from' => "whatsapp:".env("TWILIO_PHONE_NUMBER"),
                            'body' => $marketing->content,
                            'mediaUrl' => [ $marketing->image ],
                        ]
                    );
                    $messageSid[] = $message->sid;
                }  
            }
        }              
        if(!empty($messageSid)) {
            return response()->json(['status' => 'success', 'message_sid' => $messageSid]);
        } else {
            return response()->json(['status' => 'error', 'message' => "Message not sending"]);
        }
    }
    public function generate(Marketing $marketing)
    {
        
        $devJobs = [];
        if($marketing->query != '') {
            $devJobs = DB::select($marketing->query);
        }
        $devJobsResult = '';
        foreach ($devJobs as $key => $devJob) {
            $devJobsResult .="<br/> ".$devJob->title." - ".$devJob->company_name.", ".$devJob->city."<br/><a href='".route("job_details",[$devJob->job_id])."'>".route("job_details",[$devJob->job_id])."</a><br/>";
            if($key >= 4) {
                break;
            }
        }
        $marketing->content = str_replace("[DATA RESPONSE FROM QUERY]", $devJobsResult, $marketing->content);
        return response()->json([ 'marketing' => $marketing ]);
    }
    public function delete(Marketing $marketing)
    {
        $marketing->delete();
        return response()->json([ 'message' => 'Marketing record deleted successfully.' ]);
    }
    public function show(Marketing $marketing)
    {
        return response()->json([ 'marketing' => $marketing ]);
    }
}
