<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;


class CategoryDetails extends Component
{
    public $category_id;
    public $category_name;
    public $sub_category_list;
    public $sub_category_id;
    public $sub_category_name;
    public $is_sub = false;

    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function render()
    {
        return view('livewire.settings.category-details')->extends('layouts.app');
    }
    public function showModal($sub_category_id = null)
    {
        if ($sub_category_id) {
            $sub_category = SubCategoryModel::findOrFail($sub_category_id);
            $this->sub_category_name  = $sub_category->name;
            $this->is_sub  = $sub_category->is_sub;
        }
        $this->resetValidation();
        $this->sub_category_id = $sub_category_id;
        $this->modalTitle = $this->sub_category_id ? 'Edit Sub Category' : 'Add Sub Category';
        $this->modalButtonText = $this->sub_category_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function mount($category_id = null)
    {
        $this->category_id = $category_id;

        $category = CategoryModel::where('id', $category_id)->first();
        $this->category_name = $category->name;

        $this->sub_category_list = SubCategoryModel::where('category_id', $category_id)->get()->toArray();
    }
    public function onSave()
    {
        if ($this->sub_category_id) {
            $sub_category = SubCategoryModel::findOrFail($this->sub_category_id);
        } else {
            $sub_category = new SubCategoryModel;
        }
        $sub_category->name = $this->sub_category_name;
        $sub_category->category_id = $this->category_id;
        $sub_category->is_sub = $this->is_sub;
        $sub_category->save();

        $this->reset();
        $this->sub_category_list = SubCategoryModel::where('category_id', $this->category_id)->get()->toArray();
        $this->onAlert(false, 'Success', 'Sub Category saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal',['modalName' => '#sub_category_label_modal']);
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
        $this->sub_category_name = '';
        $this->sub_category_id = '';
        $this->is_sub = false;
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
