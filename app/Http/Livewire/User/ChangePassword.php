<?php

namespace App\Http\Livewire\User;

use App\Helpers\CustomHelper;
use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


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
        $user = Auth::user();
        $this->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!\Hash::check($value, \Auth::user()->password)) {
                        $fail('The current password is incorrect.');
                    }
                }
            ],
            'new_password' => 'required|min:6',
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        UserModel::where('id', $user->id)
            ->update([
                'password' => strip_tags(Hash::make($this->new_password)),
            ]);

        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Password successfully changed!', 'success');
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }
}
