<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class User extends Component
{
    public $name;
    public $email;
    public $user_list =[];
    public function render()
    {
        return view('livewire.user.user')->extends('layouts.app');
    }

    public function mount(){
        $this->user_list = [
            [
                'id' => 5358,
                'name' => 'Juan Miguel Garcia',
                'email' => 'garciajuanmiguel1105@gmail.com',
                'status' => 'active'
            ],
            [
                'id' => 9999,
                'name' => 'Juan Dela Cruz',
                'email' => 'juandelacruz@gmail.com',
                'status' => 'active'
            ]
        ];
    }

    public function onSave(){
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        dd($this->name);
    }
}
