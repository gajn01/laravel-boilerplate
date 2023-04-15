<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User as UserModel;

class UserDetails extends Component
{
    public $employee_id;
    public $name;
    public $email;
    public $status;
    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
    public function mount($employee_id = null){
        $this->employee_id = $employee_id;
        $data = UserModel::where('employee_id', $this->employee_id)->first();
        $this->name = $data->name;


    }
}
