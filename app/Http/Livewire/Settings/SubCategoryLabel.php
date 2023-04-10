<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;

class SubCategoryLabel extends Component
{
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;
    public $label_list = [];
    public $label_id;
    public $name;
    public $is_all_nothing = false;
    public $bp;
    public $is_sub = false;

    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;

    public function render()
    {
        return view('livewire.settings.sub-category-label')->extends('layouts.app');
    }
    public function mount($category_id = null, $sub_category_id = null)
    {

        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;

        $category = CategoryModel::where('id', $category_id)->first();
        $this->category_name = $category->name;

        $sub_category = SubCategoryModel::findOrFail($sub_category_id);
        $this->sub_category_name = $sub_category->name;
        $this->is_sub = $sub_category->is_sub;

        $this->label_list = SubCategoryLabelModel::where('sub_category_id', $sub_category_id)->get()->toArray();
    }


    public function showModal($label_id = null)
    {
        if ($label_id) {
            $label = SubCategoryLabelModel::findOrFail($label_id);
            $this->name = $label->name;
            $this->bp = $label->bp;
            $this->is_all_nothing = $label->is_all_nothing;
        }
        $this->resetValidation();
        $this->label_id = $label_id;
        $this->modalTitle = $this->label_id ? 'Edit Label' : 'Add Label';
        $this->modalButtonText = $this->label_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }

    public function onSave()
    {
        if ($this->label_id) {
            $label = SubCategoryLabelModel::findOrFail($this->label_id);
        } else {
            $label = new SubCategoryLabelModel;
        }
        $label->name = $this->name;
        $label->sub_category_id = $this->sub_category_id;
        if ($this->is_sub == 0) {
            $label->is_all_nothing = $this->is_all_nothing;
            $label->bp = $this->bp;
        } else {
            $label->is_all_nothing = 0;
            $label->bp = 0;
        }
        $label->save();
        $this->reset();
        $this->label_list = SubCategoryLabelModel::where('sub_category_id', $this->sub_category_id)->get()->toArray();

        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#label_modal']);
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
        $this->label_id = '';
        $this->is_all_nothing = false;
        $this->bp = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
