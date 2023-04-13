<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Dropdown as DropdownModel;
use App\Models\DropdownMenu as DropdownMenuModel;

class DropdownMenu extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $dropdown_id;
    public $dropdown_name;
    public $dropdown_menu_list = [];
    public $dropdown_menu_id;
    public $name;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function render()
    {
        return view('livewire.settings.dropdown-menu')->extends('layouts.app');
    }
    public function mount($dropdown_id = null)
    {
        $this->dropdown_name = DropdownModel::find($dropdown_id)->name;
        $this->dropdown_menu_list = DropdownMenuModel::where('dropdown_id', $dropdown_id)->get()->toArray();
    }

    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required',
            ]
        );
        DropdownMenuModel::updateOrCreate(
            ['id' => $this->dropdown_menu_id ?? null],
            [
                'dropdown_id' => $this->dropdown_id,
                'name' => strip_tags($this->name),
            ]
        );
        $this->reset();
        $this->dropdown_menu_list = DropdownMenuModel::where('dropdown_id', $this->dropdown_id)->get()->toArray();
        $this->onAlert(false, 'Success', 'Dropdown menu saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#dropdown_menu_modal']);
        $this->emit('saved');
    }

    public function showModal($dropdown_menu_id = null)
    {
        $dropdown = DropdownMenuModel::find($dropdown_menu_id);
        $this->name =  optional($dropdown)->name;
        $this->resetValidation();
        $this->dropdown_menu_id = $dropdown_menu_id;
        $this->modalTitle = $this->dropdown_menu_id ? 'Edit Dropdown' : 'Add Dropdown';
        $this->modalButtonText = $this->dropdown_menu_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function onDelete($dropdown_menu_id)
    {
        $dropdown = DropdownMenuModel::find($dropdown_menu_id);
        $dropdown->delete();
        $this->dropdown_menu_list = DropdownMenuModel::all(['id', 'name'])->toArray();
        $this->emit('saved');
    }
    public function onSearch()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->dropdown_menu_list = DropdownMenuModel::where('name', 'like', $searchTerm)
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
        $this->dropdown_menu_id = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }


}
