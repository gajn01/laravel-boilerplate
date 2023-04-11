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
    protected $listeners = ['alert-sent' => 'onAlertSent'];
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

        $data = DB::table('categories')
            ->join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('sub_categories_label', 'sub_categories.id', '=', 'sub_categories_label.sub_category_id')
            ->join('sub_sub_categories', 'sub_categories_label.id', '=', 'sub_sub_categories.sub_sub_category_id')
            ->select(
                'categories.name as category_name',
                'sub_categories.name as sub_category_name',
                'sub_categories_label.name as sub_sub_category_name',
                'sub_sub_categories.*',
            )
            ->where('categories.id', '=', $category_id)
            ->where('sub_categories.id', '=', $sub_category_id)
            ->where('sub_categories_label.id', '=', $sub_sub_category_id)
            ->get();

        $this->category_name = $data[0]->category_name;
        $this->sub_category_name = $data[0]->sub_category_name;
        $this->sub_sub_category_name = $data[0]->sub_sub_category_name;
        $this->label_list = json_decode(json_encode($data->toArray()), true);

    }
    public function showModal($label_id = null)
    {
        $label = SubSubCategoryLabelModel::find($label_id);
        $this->name = optional($label)->name;
        $this->bp = optional($label)->bp;
        $this->is_all_nothing = optional($label)->is_all_nothing ?? false;
        $this->resetValidation();
        $this->label_id = $label_id;
        $this->modalTitle = $label_id ? 'Edit Label' : 'Add Label';
        $this->modalButtonText = $label_id ? 'Update' : 'Add';
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
        $this->label_list = SubSubCategoryLabelModel::where('sub_sub_category_id', $this->sub_sub_category_id)
            ->when($label->subCategoryLabel, function ($query) {
                return $query->with('someRelationship');
            })
            ->get()
            ->toArray();
        $this->reset();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sub_category_label_modal']);
        $this->emit('saved');
    }

    public function onDelete($id)
    {
        $store = SubSubCategoryLabelModel::find($id);
        $store->delete();
        $this->label_list = array_values(array_filter($this->label_list, function ($label) use ($id) {
            return $label['id'] != $id;
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
