<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubSubCategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\Dropdown as DropdownModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;


class SubSubCategoryLabel extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;
    public $sub_sub_category_name;
    public $sub_sub_category_id;
    public $label_id;
    public $name;
    public $is_all_nothing = false;
    public $bp;
    public $dropdown_list;
    public $dropdown_id;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount($category_id = null, $sub_category_id = null, $sub_sub_category_id = null)
    {
        if (!Gate::allows('allow-view', 'module-category-management')) {
            return redirect()->route('dashboard');
        }
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sub_sub_category_id = $sub_sub_category_id;
        $this->category_name = CategoryModel::where('id', $category_id)->value('name');
        $this->sub_category_name = SubCategoryModel::where('id', $sub_category_id)->value('name');
        $this->sub_sub_category_name = SubSubCategoryModel::where('id', $sub_sub_category_id)->value('name');
        $this->dropdown_list = DropdownModel::get();
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $label_list = SubSubCategoryLabelModel::select('id', 'name', 'sub_sub_category_id', 'bp', 'is_all_nothing', 'dropdown_id')
            ->where('sub_sub_category_id', $this->sub_sub_category_id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->paginate($this->limit);
        return view('livewire.settings.sub-sub-category-label', ['label_list' => $label_list])->extends('layouts.app');
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
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->label_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $labelData = [
            'name' => $this->name,
            'sub_sub_category_id' => $this->sub_sub_category_id,
            'is_all_nothing' => $this->is_all_nothing,
            'bp' => $this->bp,
            'dropdown_id' => $this->dropdown_id ?? '0',
        ];
        SubSubCategoryLabelModel::updateOrCreate(['id' => $this->label_id], $labelData);
        $this->reset();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#sub_category_label_modal');
        $action = $this->label_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Sub-sub-category label', $this->label_id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $sub_category = SubSubCategoryLabelModel::find($id);
        $sub_category->delete();
        $this->activity->onLogAction('delete','Sub-sub-category label', $this->label_id ?? null);

    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }
}
