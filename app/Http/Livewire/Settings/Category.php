<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Category as CategoryModel;
use App\Models\CriticalDeviation as CriticalDeviationModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;
class Category extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $category_id;
    public $name;
    public $type;
    public $critical_deviation_id;
    public $order;
    public $ros;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount(){
        if (!Gate::allows('allow-view', 'module-category-management')) {
            return redirect()->route('dashboard');
        }
    }
    public function render()
    {
        $deviation = CriticalDeviationModel::all('id', 'name');
        $searchTerm = '%' . $this->searchTerm . '%';
        $category_list = CategoryModel::where('name', 'like', $searchTerm)
            ->orderBy('type', 'DESC')
            ->orderBy('order', 'ASC')
            ->paginate($this->limit);
        return view('livewire.settings.category', ['category_list' => $category_list, 'deviation_list' => $deviation])->extends('layouts.app');
    }
    public function showModal($category_id = null)
    {
        $category = CategoryModel::find($category_id);
        $this->name = optional($category)->name;
        $this->order = optional($category)->order;
        $this->type = optional($category)->type;
        $this->ros = optional($category)->ros;
        $this->critical_deviation_id = optional($category)->critical_deviation_id;
        $this->category_id = $category_id;
        $this->modalTitle = $this->category_id ? 'Edit Category' : 'Add Category';
        $this->modalButtonText = $this->category_id ? 'Update' : 'Add';
        $this->reset();
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->category_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:0,1',
            'order' => 'required',
        ]);
        CategoryModel::updateOrCreate(
            ['id' => $this->category_id ?? null],
            [
                'name' => strip_tags($this->name),
                'order' => strip_tags($this->order),
                'type' => strip_tags($this->type),
                'ros' => strip_tags($this->ros),
                'critical_deviation_id' => $this->critical_deviation_id ? $this->critical_deviation_id : null,
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Category saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#category_modal');
        $action = $this->category_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Category', $this->category_id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $category = CategoryModel::find($id);
        $category->delete();
        $this->activity->onLogAction('delete','Category', $this->category_id ?? null);
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
