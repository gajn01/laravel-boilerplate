<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;
class CategoryDetails extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $category_id;
    public $category_name;
    public $sub_category_id;
    public $sub_category_name;
    public $is_sub = false;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount($category_id = null)
    {
        if (!Gate::allows('allow-view', 'module-category-management')) {
            return redirect()->route('dashboard');
        }
        $this->category_id = $category_id;
        $category = CategoryModel::with('subCategories')->where('id', $category_id)->first();
        $this->category_name = $category->name;
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $sub_category_list = SubCategoryModel::select('id', 'name', 'is_sub', 'category_id')
            ->where('category_id', $this->category_id)
            ->Where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->paginate($this->limit);
        return view('livewire.settings.category-details', ['sub_category_list' => $sub_category_list])->extends('layouts.app');
    }
    public function showModal($sub_category_id = null)
    {
        $sub_category = SubCategoryModel::find($sub_category_id);
        $this->sub_category_name = optional($sub_category)->name;
        $this->is_sub = optional($sub_category)->is_sub ?? 0;
        $this->resetValidation();
        $this->sub_category_id = $sub_category_id;
        $this->modalTitle = $this->sub_category_id ? 'Edit Sub Category' : 'Add Sub Category';
        $this->modalButtonText = $this->sub_category_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->sub_category_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->validate([
            'sub_category_name' => 'required|max:255',
        ]);
        $sub_category_name = strip_tags($this->sub_category_name);
        $is_sub = strip_tags($this->is_sub);
        SubCategoryModel::updateOrCreate(
            ['id' => $this->sub_category_id ?? null],
            [
                'name' => $sub_category_name,
                'category_id' => $this->category_id,
                'is_sub' => intval($is_sub ?? 0),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Sub category saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#sub_category_label_modal');
        $action = $this->sub_category_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Sub-category', $this->sub_category_id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $sub_category = SubCategoryModel::find($id);
        $sub_category->delete();
        $this->activity->onLogAction('delete','Sub-category', $this->sub_category_id ?? null);
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
