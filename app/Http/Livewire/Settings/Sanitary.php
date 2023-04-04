<?php

namespace App\Http\Livewire\Settings;
use App\Models\SanitaryModel;

use Livewire\Component;

class Sanitary extends Component
{
    public $sanitary_list = [];
    public $sanitary_id;
    public $title;
    public $code;
    public $is_save = true;

    public function render()
    {
        return view('livewire.settings.sanitary')->extends('layouts.app');
    }
    public function mount()
    {
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
    }

    public function onSave(){
        $this->validate([
            'title' => 'required',
            'code' => 'required',
        ], [
            'title.required' => 'The title field is required.',
            'code.required' => 'The code field is required.',
        ]);
        $sanitary = new SanitaryModel();
        $sanitary->title = $this->title;
        $sanitary->code = $this->code;
        $sanitary->save();
        $this->reset();
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        $this->onAlert(false,'Success','Sanitation defect saved successfully!','success');
        $this->dispatchBrowserEvent('remove-modal');
        $this->emit('saved');
    }
    public function getSanitaryId($sanitary_id)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $this->title = $sanitary->title;
        $this->code = $sanitary->code;
        $this->sanitary_id = $sanitary_id;
        $this->is_save = false;
    }

    public function onDeleteSanitary($sanitary_id){
        /* $this->onAlert(true,'Confirm','Are you sure you want to delete this sanitation defect?','warning',$sanitary_id); */
        $sanitary = SanitaryModel::find($sanitary_id);
        $sanitary->delete();
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        $this->emit('saved');
        return redirect()->route('sanitary');

    }
    public function onAlert($is_confirm = false ,$title = null,$message = null,$type = null,$data=null)
    {
        $alert = $is_confirm ? 'confirm-alert' : 'show-alert';
        $this->dispatchBrowserEvent($alert, [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data

        ]);
    }

    public function reset(...$properties){

        $this->title = '';
        $this->code = '';
        $this->sanitary_id = '';
        $this->resetValidation();
    }

    protected $listeners = ['alert-sent' => 'onAlertSent'];

    public function onAlertSent($data)
    {
        $this->onDeleteSanitary($data);
    }
}
