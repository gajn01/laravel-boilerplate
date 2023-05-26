<?php
namespace App\Http\Livewire\Dashboard;
use App\Models\Store as StoreModel;
use App\Models\Summary as SummaryModel;
use Livewire\Component;
class Dashboard extends Component
{
    public function render()
    {
        $storeCounts = StoreModel::select('type', \DB::raw('count(*) as count'))
        ->groupBy('type')
        ->get()->toArray();

        $completion = SummaryModel::select('type', \DB::raw('count(*) as count'))
        ->groupBy('type')
        ->get()->toArray();


        return view('livewire.dashboard.dashboard',['store' => $storeCounts , 'completion' => $completion])->extends('layouts.app');
    }
}
