<?php
namespace App\Http\Livewire\Dashboard;
use App\Models\Store as StoreModel;
use Livewire\Component;
class Dashboard extends Component
{
    public function render()
    {
        $storeCounts = StoreModel::select('type', \DB::raw('count(*) as count'))
        ->groupBy('type')
        ->get()->toArray();
        return view('livewire.dashboard.dashboard',['store' => $storeCounts])->extends('layouts.app');
    }
}
