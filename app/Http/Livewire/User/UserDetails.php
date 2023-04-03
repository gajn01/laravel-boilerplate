<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserDetails extends Component
{
    public $user_id;

    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
    public function mount($user_id){
        $this->user_id = $user_id;
    }
}
