<?php
namespace App\Http\Livewire\Settings;
use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubSubCategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\Dropdown as DropdownModel;

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
    public $dropdown_list = [];
    public $dropdown_id;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;

    public $cln_bp;
    public $cln_is_all;
    public $con_bp;
    public $con_is_all;
    public function render()
    {
        return view('livewire.settings.sub-sub-category-label')->extends('layouts.app');
    }
    public function mount($category_id = null, $sub_category_id = null, $sub_sub_category_id = null)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sub_sub_category_id = $sub_sub_category_id;
        $this->category_name = CategoryModel::where('id', $category_id)->value('name');
        $this->sub_category_name = SubCategoryModel::where('id', $sub_category_id)->value('name');
        $this->sub_sub_category_name = SubSubCategoryModel::where('id', $sub_sub_category_id)->value('name');
        $this->label_list = SubSubCategoryLabelModel::where('sub_sub_category_id', $sub_sub_category_id)->get()->toArray();
        $this->dropdown_list = DropdownModel::get()->toArray();

    }
    public function showModal($label_id = null)
    {
        $label = SubSubCategoryLabelModel::find($label_id);
        $this->name = optional($label)->name;
        $this->bp = optional($label)->bp;
        $this->is_all_nothing = optional($label)->is_all_nothing ?? false;
        $this->dropdown_id = optional($label)->dropdown_id;
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
            'bp' => $this->bp,
            'dropdown_id' => $this->dropdown_id  ?? '0',
        ];
        SubSubCategoryLabelModel::updateOrCreate(['id' => $this->label_id], $labelData);
        $this->label_list = SubSubCategoryLabelModel::where('sub_sub_category_id', $this->sub_sub_category_id)
            ->get()
            ->toArray();
        $this->reset();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sub_category_label_modal']);
        $this->emit('saved');
    }
    public function onSearch()
    {
        $query = SubSubCategoryLabelModel::select('id', 'name', 'sub_sub_category_id', 'is_all_nothing', 'bp')
            ->where('sub_sub_category_id', $this->sub_sub_category_id);
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        $this->label_list = $query->get(['id', 'name', 'sub_sub_category_id', 'is_all_nothing', 'bp'])->toArray();
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
        $this->dropdown_id = 0;
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
