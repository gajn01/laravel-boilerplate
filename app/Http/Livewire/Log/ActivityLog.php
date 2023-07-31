<?php

namespace App\Http\Livewire\Log;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use App\Models\ActivityLog as ActivityLogModel;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class ActivityLog extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    private $timezone, $time, $year;
    public $limit = 10;
    public $date_today;
    public $date_filter;
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->year = $this->time->format('Y');
        $this->date_today = $this->time->format('Y-m-d');
    }

    public function mount()
    {
      /*   if (auth()->user()->user_type  != 0 || auth()->user()->user_type != 1){
            return redirect()->route('dashboard');
        } */
    }
    public function render()
    {
        $activity = ActivityLogModel::query();

        if ($this->date_filter) {
            if ($this->date_filter == 'weekly') {
                $activity->whereBetween('date_created', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($this->date_filter == 'monthly') {
                $activity->whereBetween('date_created', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
            } elseif ($this->date_filter == $this->date_today) {
                $activity->where('date_created', $this->date_today);
            }
        }
        // Use the paginate() method after the conditions have been applied
        $activity = $activity->orderBy('date_created', 'desc')->paginate($this->limit);
    
        return view('livewire.log.activity-log', ['activity' => $activity])->extends('layouts.app');
    }

}