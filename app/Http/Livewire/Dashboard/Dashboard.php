<?php
namespace App\Http\Livewire\Dashboard;

use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;
use Livewire\Component;
use DateTime;
use DateTimeZone;
use App\Models\Store as StoreModel;
use App\Models\Summary as SummaryModel;
use App\Models\AuditDate;
use App\Models\AuditForm;
class Dashboard extends Component
{
    private $timezone,$time,$year;
    public $wave = 1;
    public $date_today;
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->year = $this->time->format('Y');
        $this->date_today = $this->time->format('Y-m-d');

    }
    public function render()
    {   
        $activity = ActivityLog::orderBy('date_created', 'desc')->paginate(5);
        $passingRate = SummaryModel::select('type', \DB::raw('count(overall_score) as count'))->where('overall_score', 1)->groupBy('type')->get();
        $storeCounts = StoreModel::select('type', \DB::raw('count(*) as count'))->groupBy('type')->get();
        $completion = SummaryModel::select('type', \DB::raw('count(*) as count'))
            ->where('wave', $this->wave)
            ->where('date_of_visit', 'LIKE', $this->year . '-%')
            ->whereNotNull('received_by')
            ->groupBy('type')
            ->get();
        $getScheduleToday = $this->getSchedule();
        return view('livewire.dashboard.dashboard', ['schedule'=> $getScheduleToday,'storeCounts' => $storeCounts, 'completion' => $completion, 'passingRate' => $passingRate,'activity'=>$activity])->extends('layouts.app');
    }

    public function getSchedule(){
        return AuditForm::where('audit_date',$this->date_today)->paginate(5);
    }
}