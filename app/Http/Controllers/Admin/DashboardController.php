<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DevJob;
use App\Models\Developer;
use App\Models\DevJobsLog;
use App\Models\User;
use App\Models\JobTitleClicked;
use App\Models\ButtonClicked;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index() {
        $devJobsCount = DevJob::where("is_open", 1)->count();
        $developerCount = Developer::count();
        $usersCount = User::where("type", "!=", 2)->count();
        $jobTitleClickedCount = JobTitleClicked::count();
        $buttonClickedCount = ButtonClicked::where("button_type", 1)->count();
        $buttonApplyCVCount = ButtonClicked::where("button_type", 2)->count();
        $devJobsLog = DevJobsLog::where('date', date('Y-m-d'))->first();
        $todayDeveloperCount = Developer::whereDate('created_at', date('Y-m-d'))->count();
        $todayNewUsers = User::where("type", "!=", 2)->whereDate('created_at', date('Y-m-d'))->count();
        $todayViewClicks = JobTitleClicked::whereDate('created_at', date('Y-m-d'))->count();
        $todayApplyClicks = ButtonClicked::whereDate('created_at', date('Y-m-d'))->where("button_type", 1)->count();
        $todayApplyCV = ButtonClicked::whereDate('created_at', date('Y-m-d'))->where("button_type", 2)->count();
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        $userCounts = User::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')->toArray();
        $developerCounts = Developer::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')->toArray();

        $titleClickedCounts = JobTitleClicked::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')->toArray();

        $buttonClickedCounts = ButtonClicked::select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))->whereBetween('created_at', [$startDate, $endDate])->where("button_type", 1)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')->toArray();
        $userCountsByDay = [];
        $titleClickCountsByDay = [];
        $buttonClickCountsByDay = [];
        $developersCountsByDay = [];
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->toDateString();

            $userCountsByDay[$date->format('M d')] = (isset($userCounts[$formattedDate])?$userCounts[$formattedDate]:0);
            $developersCountsByDay[$date->format('M d')] = (isset($developerCounts[$formattedDate])?$developerCounts[$formattedDate]:0);
            $titleClickCountsByDay[$date->format('M d')] = (isset($titleClickedCounts[$formattedDate])?$titleClickedCounts[$formattedDate]:0);
            $buttonClickCountsByDay[$date->format('M d')] = (isset($buttonClickedCounts[$formattedDate])?$buttonClickedCounts[$formattedDate]:0);
        }
        // dd($userCountsByDay);        

        return view('admin.dashboard', compact('devJobsCount','todayDeveloperCount', 'developerCount', 'usersCount', 'buttonClickedCount', 'buttonApplyCVCount', 'jobTitleClickedCount', 'devJobsLog', 'todayNewUsers', 'todayViewClicks', 'todayApplyClicks', 'todayApplyCV', 'userCountsByDay', 'titleClickCountsByDay', 'buttonClickCountsByDay', 'developersCountsByDay'));
    }
}
