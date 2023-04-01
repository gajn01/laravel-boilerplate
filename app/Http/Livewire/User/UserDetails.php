<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class UserDetails extends Component
{
    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
}
