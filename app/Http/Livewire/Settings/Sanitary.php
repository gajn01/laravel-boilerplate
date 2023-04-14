<?php

namespace App\Http\Livewire\Settings;

use App\Models\SanitaryModel;
use Livewire\Component;
use Livewire\WithPagination;
class Sanitary extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $sanitary_id;
    public $title;
    public $code;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $sanitary_list = SanitaryModel::select('id', 'title', 'code')
            ->where('title', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.sanitary',['sanitary_list' => $sanitary_list])->extends('layouts.app');
    }
    public function showModal($sanitary_id = null)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $this->title = optional($sanitary)->title;
        $this->code = optional($sanitary)->code;
        $this->resetValidation();
        $this->sanitary_id = $sanitary_id;
        $this->modalTitle = $this->sanitary_id ? 'Edit Sanitation Defect' : 'Add Sanitation Defect';
        $this->modalButtonText = $this->sanitary_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
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
        $this->onAlert(false, 'Success', 'Sanitation defect saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sanitaryModal']);
        $this->emit('saved');
    }
    public function onDelete($sanitary_id)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $sanitary->delete();
        $this->emit('saved');
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
