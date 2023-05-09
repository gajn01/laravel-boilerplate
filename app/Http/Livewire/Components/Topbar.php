<?php
namespace App\Http\Livewire\Components;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
class Topbar extends Component
{
    public $name = "test";
    public $notifications = 3;
    public function logout()
    {
        dd('logout');
        /*     Auth::logout();
        return redirect()->to('/login');
        */
    }
    public function render()
    {
        return view('livewire.components.topbar')->extends('layouts.app');
    }
}
