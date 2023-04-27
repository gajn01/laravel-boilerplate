<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User as UserModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
class UserDetails extends Component
{
    public $account_id;
    public $employee_id;
    public $name;
    public $input_employee_id;
    public $input_name;
    public $input_email;
    public $input_status;
    public $email;
    public $status;
    public $is_edit = false;
    public $modalButtonText;

    public function render()
    {
        return view('livewire.user.user-details')->extends('layouts.app');
    }
    public function mount($employee_id = null){
        $this->employee_id = $employee_id;
        $data = UserModel::where('employee_id', $this->employee_id)->first();
        $this->account_id = optional($data)->id;
        $this->name = optional($data)->name;
        $this->email = optional($data)->email;
        $this->status = optional($data)->status;
    }
    public function onUpdate($boolean){
        $this->input_employee_id = $this->employee_id;
        $this->input_name = $this->name;
        $this->input_email = $this->email;
        $this->input_status = $this->status;
        $this->is_edit = $boolean;
    }
    public function onSaveAccount()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email',
            ]
        );
        UserModel::updateOrCreate(
            ['id' => $this->account_id ?? null],
            [
                'name' => strip_tags($this->input_name),
                'email' => strip_tags($this->input_email),
                'status' => strip_tags($this->input_status),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Account saved successfully!', 'success');
        $this->onUpdate(false);
    }
    public function onTogglePassword(){
      /*   $this->is_toggle = !$this->is_toggle; */
        $this->emit('toggleEye');
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
