<?php
namespace App\Http\Livewire\Components;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
class Topbar extends Component
{
    public $name = "test";
    public function logout()
    {
        dd('logout');
        /*     Auth::logout();
        return redirect()->to('/login');
        */
    }
    public function render()
    {
        return view('livewire.components.topbar');
    }
}
