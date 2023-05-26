<?php
namespace App\Http\Livewire\Dashboard;

use App\Models\Store as StoreModel;
use App\Models\Summary as SummaryModel;
use Illuminate\Support\Facades\DB;

use Livewire\Component;
use DateTime;
use DateTimeZone;

class Dashboard extends Component
{
    private $timezone;
    private $time;
    private $year;
    public $wave = 'Wave 1';
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->year = $this->time->format('Y');
    }
    public function render()
    {
        $storeCounts = StoreModel::select('type', \DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();
        $completion = SummaryModel::select('type', \DB::raw('count(*) as count'))
            ->where('wave', $this->wave)
            ->where('date_of_visit', 'LIKE', $this->year . '-%')
            ->groupBy('type')
            ->get();
        return view('livewire.dashboard.dashboard', ['storeCounts' => $storeCounts, 'completion' => $completion])
            ->extends('layouts.app');
    }

}
