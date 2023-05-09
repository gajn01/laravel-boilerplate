<?php
namespace App\Http\Livewire\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;
use App\Helpers\CustomHelper;

class Profile extends Component
{
    public $employee_id;
    public $name;
    public $input_employee_id;
    public $input_name;
    public $input_email;
    public $input_status;
    public $email;
    public $status;
    public $is_edit = false;
    public $profile;
    public function render()
    {
        $id = Auth::user()->id;
        $user = UserModel::where('id', $id)->first();
        $this->profile = $user;
        return view('livewire.user.profile',['user' => $user])->extends('layouts.app');
    }

    public function onUpdate($boolean)
    {
        $this->input_employee_id = $this->profile->employee_id;
        $this->input_name = $this->profile->name;
        $this->input_email = $this->profile->email;
        $this->input_status = $this->profile->status;
        $this->is_edit = $boolean;
    }
    public function onSaveAccount(){
        $this->validate([
            'input_employee_id' => 'required',
            'input_name' => 'required',
            'input_email' => 'required|email',
            'input_status' => 'required',
        ]);
        UserModel::where('id', $this->profile->id)
        ->update([
            'name' => strip_tags($this->input_name),
            'email' => strip_tags($this->input_email),
            'status' => strip_tags($this->input_status),
        ]);

        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Account saved successfully!', 'success');
        $this->onUpdate(false);
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
