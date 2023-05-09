<?php

namespace App\Http\Livewire\User;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $confirm_password;
    public function render()
    {
        return view('livewire.user.change-password')->extends('layouts.app');
    }

    public function onChangePassword()
    {
        $this->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, \Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'new_password' => 'required|min:6',
            'confirm_password' => ['required', 'same:new_password'],
        ]);
    }
}
