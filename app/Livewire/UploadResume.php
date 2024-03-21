<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Mail\SendEmailWithAttachment;
use Illuminate\Support\Facades\Mail;
use Livewire\WithFileUploads;
use Auth;
use App\Models\DevJob;
use App\Models\UserUploadedManuallyCV;
use Illuminate\Support\Facades\Request;

class UploadResume extends Component
{
    use WithFileUploads;
    public $resume;
    public $jobId;
    public $pageType;
    public $additionalText;
    public $resumeUploadFileKey = 0;
    protected $listeners = [
        'setJobId'
    ];
    public function setJobId($jobId, $pageUrl) 
    {
        $this->jobId = $jobId;
        if($pageUrl == "/"){
            $this->pageType = 1;
        } else if($pageUrl == "/jobs-grid"){
            $this->pageType = 2;
        } else if(strpos($pageUrl, '/company-details') === 0){
            $this->pageType = 5;
        } else {
            $this->pageType = 4;
        }
    }
    public function submit()
    {
        $this->validate([
            'resume' => 'required|file|max:2048', 
        ]);
        $devJob = DevJob::where("job_id", $this->jobId)->first();
        if(!empty($devJob)) {
            $fileName = Auth::id()."_cv_".$this->resume->getClientOriginalName();
            $originalFileName = $this->resume->getClientOriginalName();
            $filePath = $this->resume->storeAs(path:'public/manualy_cv', name:$fileName);
            // $this->resume->delete();
            $attachmentPath = storage_path('app/public/manualy_cv/'.$fileName);
            
            $user = Auth::user();
            $body = '<p>Hi,</p>
    <p>You’ve received new resume for job position: “'.$devJob->title.'”.</p>
    <p>Job Id: '.$devJob->job_id.'</p>
    <p>Job URL: <a href="'.route('job_details',[ $devJob->job_id ]).'">'.route('job_details',[ $devJob->job_id ]).'</a></p>
    <p>Candidate name: '.$user->name.'</p>
    <p>Candidate email: '.$user->email.'</p>
    <p>Candidate Cover Letter:</p>
    <p>'.$this->additionalText.'</p>

    <p>Good Luck</p>
    <p>Team DevJobs</p>.';
            if($devJob->company->email_address != '') {
                Mail::send([], [], function ($message) use ($attachmentPath, $originalFileName, $body, $devJob, $user) {
                    $message->to($devJob->company->email_address)
                        ->subject('New Resume from '.$user->name.' for job position: “'.$devJob->title.'”')
                        ->html($body)
                        ->attach($attachmentPath, ['as' => $originalFileName]);
                });
            }
            UserUploadedManuallyCV::create([
                "user_id" => $user->id,
                "job_id" => $devJob->job_id,
                "company_id" => $devJob->company_id,
                "additional_text" => $this->additionalText,
                "cv_file" => $fileName,
            ]);

            buttonClicked($devJob->company_id, $devJob->job_id, $this->pageType, 2);
            $this->reset('resume');
            $this->resumeUploadFileKey++;
            $this->additionalText = '';
            $this->dispatch('resetUploadResume');
            $this->dispatch('showToastMessage', 'Success', 'Resume sent successfully.');
        } else {
            $this->dispatch('showToastMessage', 'Error', 'Please try again to upload your resume.');
        }
    }
    public function render()
    {
        return view('livewire.upload-resume');
    }
}
