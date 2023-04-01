<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class User extends Component
{
    public $name;
    public $email;
    public function render()
    {
        return view('livewire.user.user')->extends('layouts.app');
    }


    public function onSave(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        dd($this->name);
    }
}
