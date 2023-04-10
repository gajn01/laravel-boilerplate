<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    public $category_list = [];
    public $category_id;
    public $name;
    public $type;

    public function render()
    {
        return view('livewire.settings.category')->extends('layouts.app');
    }
    public function mount()
    {
        $this->category_list = CategoryModel::all(['id','name', 'type'])->toArray();

    }

    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'type' => 'required|in:0,1',
            ]
        );

        if ($this->category_id) {
            $category = CategoryModel::findOrFail($this->category_id);
        } else {
            $category = new CategoryModel();
        }
        $category->name = $this->name;
        $category->type = $this->type;
        $category->save();

        $this->reset();
        $this->category_list = CategoryModel::all(['id','name', 'type'])->toArray();
        $this->onAlert(false, 'Success', 'Category saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal',['modalName' => '#category_modal']);
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
        $this->name = '';
        $this->category_id = '';
        $this->type = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}

