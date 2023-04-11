<?php

namespace App\Http\Livewire\Settings;


use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;

class SubSubCategoryLabel extends Component
{
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;
    public $sub_sub_category_name;
    public $sub_sub_category_id;
    public $label_list = [];

    public $label_id;
    public $name;
    public $is_all_nothing = false;
    public $bp;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;

    public function render()
    {
        return view('livewire.settings.sub-sub-category-label')->extends('layouts.app');
    }
    public function mount($category_id = null, $sub_category_id = null, $sub_sub_category_id = null)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sub_sub_category_id = $sub_sub_category_id;

        /*     $category = CategoryModel::where('id', $category_id)->first();
        $this->category_name = $category->name;
        $sub_category = SubCategoryModel::where('id', $sub_category_id)->first();
        $this->sub_category_name = $sub_category->name;
        $sub_sub_category_label = SubCategoryLabelModel::where('id', $sub_sub_category_id)->first();
        $this->sub_sub_category_name = $sub_sub_category_label->name;
        $this->label_list = SubSubCategoryLabelModel::where('sub_sub_category_id', $sub_sub_category_id)->get()->toArray();
        */
        $data = CategoryModel::with([
            'subCategories' => function ($query) use ($sub_category_id) {
                $query->where('id', $sub_category_id);
            },
            'subCategories.labels' => function ($query) use ($sub_sub_category_id) {
                $query->where('id', $sub_sub_category_id);
            },
            'subCategories.labels.subSubCategoryLabels'
        ])->find($category_id);

        $this->category_name = $data->name;
        $subCategory = $data->subCategories->first();
        $this->sub_category_name = $subCategory->name;
        $subCategoryLabel = $subCategory->labels->first();
        $this->sub_sub_category_name = $subCategoryLabel->name;
        $this->label_list = $subCategoryLabel->subSubCategoryLabels->toArray();

    }
    public function showModal($label_id = null)
    {
        if ($label_id) {
            $label = SubSubCategoryLabelModel::findOrFail($label_id);
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
        $labelData = [
            'name' => $this->name,
            'sub_sub_category_id' => $this->sub_sub_category_id,
            'is_all_nothing' => $this->is_all_nothing,
            'bp' => $this->bp
        ];

        $label = SubSubCategoryLabelModel::updateOrCreate(['id' => $this->label_id], $labelData);

        $subCategoryLabel = $label->subCategoryLabel;
        $this->label_list = SubSubCategoryLabelModel::where('sub_sub_category_id', $this->sub_sub_category_id)
            ->when($subCategoryLabel, function ($query) {
                return $query->with('someRelationship');
            })
            ->get()
            ->toArray();

        $this->reset();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sub_category_label_modal']);
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
