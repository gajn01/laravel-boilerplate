<?php
namespace App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard.dashboard')->extends('layouts.app');
    }
}
