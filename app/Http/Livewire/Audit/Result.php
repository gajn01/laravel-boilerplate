<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
/* models  */
use App\Models\Store;
use App\Models\AuditForm;

use DateTime;
use DateTimeZone;

class Result extends Component
{
    public $active_index = 0;
    public  $form;
    public $auditForm;
    public Store $store;
   
    public function mount($form_id = null)
    {
        $this->auditForm = AuditForm::find($form_id);
        $this->form = json_decode($this->auditForm->audit_result, true);
        $this->store = Store::find($this->auditForm->store_id);
    }
    public function render()
    {
        return view('livewire.audit.result')->extends('layouts.app');
    }
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    #region intialization
}