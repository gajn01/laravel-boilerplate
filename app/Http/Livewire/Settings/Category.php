<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $category_list = [];
    public $category_id;
    public $name;
    public $type;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;

    public function render()
    {
        return view('livewire.settings.category')->extends('layouts.app');
    }
    public function mount()
    {
        $this->category_list = CategoryModel::all(['id', 'name', 'type'])->toArray();
    }
    public function showModal($category_id = null)
    {
        $category = CategoryModel::find($category_id);
        $this->name = optional($category)->name;
        $this->type = optional($category)->type;
        $this->resetValidation();
        $this->category_id = $category_id;
        $this->modalTitle = $this->category_id ? 'Edit Category' : 'Add Category';
        $this->modalButtonText = $this->category_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function onSave()
    {
        $this->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:0,1',
        ]);
        CategoryModel::updateOrCreate(
            ['id' => $this->category_id ?? null],
            [
                'name' => strip_tags($this->name),
                'type' => strip_tags($this->type),
            ]
        );
        $this->reset();
        $this->category_list = CategoryModel::all(['id', 'name', 'type'])->toArray();
        $this->onAlert(false, 'Success', 'Category saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#category_modal']);
        $this->emit('saved');
    }
    public function onSearch()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $this->category_list = CategoryModel::where('name', 'like', $searchTerm)
            ->orWhere('name', 'like', $searchTerm)
            ->get(['id', 'name', 'type'])
            ->toArray();
    }
    public function onDelete($id)
    {
        $category = CategoryModel::find($id);
        $category->delete();
        $this->category_list = array_values(array_filter($this->category_list, function ($data) use ($id) {
            return $data['id'] != $id;
        }));
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
