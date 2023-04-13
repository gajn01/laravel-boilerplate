<?php
namespace App\Http\Livewire\Settings;
use Livewire\Component;
use App\Models\Dropdown as DropdownModel;
class Dropdown extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $dropdown_list = [];
    public $dropdown_id;
    public $name;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function render()
    {
        return view('livewire.settings.dropdown')->extends('layouts.app');
    }
    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required',
            ]
        );
        DropdownModel::updateOrCreate(
            ['id' => $this->dropdown_id ?? null],
            [
                'name' => strip_tags($this->name),
            ]
        );
        $this->reset();
        $this->dropdown_list = DropdownModel::all()->toArray();
        $this->onAlert(false, 'Success', 'Dropdown saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#dropdown_modal']);
        $this->emit('saved');
    }
    public function mount()
    {
        $this->dropdown_list = DropdownModel::all()->toArray();
    }
    public function showModal($dropdown_id = null)
    {
        $dropdown = DropdownModel::find($dropdown_id);
        $this->name =  optional($dropdown)->name;
        $this->resetValidation();
        $this->dropdown_id = $dropdown_id;
        $this->modalTitle = $this->dropdown_id ? 'Edit Dropdown' : 'Add Dropdown';
        $this->modalButtonText = $this->dropdown_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function onDelete($dropdown_id)
    {
        $dropdown = DropdownModel::find($dropdown_id);
        $dropdown->delete();
        $this->dropdown_list = DropdownModel::all(['id', 'name'])->toArray();
        $this->emit('saved');
    }
    public function onSearch()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->dropdown_list = DropdownModel::where('name', 'like', $searchTerm)
            ->get(['id', 'name'])
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
        $this->name = '';
        $this->dropdown_id = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
