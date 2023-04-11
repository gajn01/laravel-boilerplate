<?php

namespace App\Http\Livewire\Settings;

use App\Models\SanitaryModel;

use Livewire\Component;

class Sanitary extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $sanitary_list = [];
    public $sanitary_id;
    public $title;
    public $code;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function showModal($sanitary_id = null)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $this->title =  optional($sanitary)->title;
        $this->code =  optional($sanitary)->code;
        $this->resetValidation();
        $this->sanitary_id = $sanitary_id;
        $this->modalTitle = $this->sanitary_id ? 'Edit Sanitation Defect' : 'Add Sanitation Defect';
        $this->modalButtonText = $this->sanitary_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function render()
    {
        return view('livewire.settings.sanitary')->extends('layouts.app');
    }
    public function mount()
    {
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
    }
    public function onSave()
    {
        $this->validate(
            [
                'title' => 'required',
                'code' => 'required',
            ]
        );
        SanitaryModel::updateOrCreate(
            ['id' => $this->sanitary_id ?? null],
            [
                'title' => strip_tags($this->title),
                'code' => strip_tags($this->code),
            ]
        );
        $this->reset();
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        $this->onAlert(false, 'Success', 'Sanitation defect saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sanitaryModal']);
        $this->emit('saved');
    }
    public function onDelete($sanitary_id)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $sanitary->delete();
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        $this->emit('saved');
    }
    public function onSearch()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->sanitary_list = SanitaryModel::where('title', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->get(['id', 'title', 'code'])
            ->toArray();
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        $alert = $is_confirm ? 'confirm-alert' : 'show-alert';
        $this->dispatchBrowserEvent($alert, [
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'data' => $data
        ]);
    }
    public function reset(...$properties)
    {
        $this->title = '';
        $this->code = '';
        $this->sanitary_id = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
