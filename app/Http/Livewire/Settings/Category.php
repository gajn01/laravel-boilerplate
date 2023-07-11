<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\CriticalDeviation as CriticalDeviationModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;

class Category extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $category_id;
    public $name;
    public $type;
    public $critical_deviation;
    public $order;
    public $ros;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
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
        $this->critical_deviation = optional($category)->critical_deviation;
        $this->category_id = $category_id;
        $this->modalTitle = $this->category_id ? 'Edit Category' : 'Add Category';
        $this->modalButtonText = $this->category_id ? 'Update' : 'Add';
        $this->reset();
    }
    public function onSave()
    {
        $this->validate([
            'name' => 'required|max:255',
            'type' => 'required|in:0,1',
            'order' => 'required',
            'ros' => '',
            'critical_deviation' => '',
        ]);
        CategoryModel::updateOrCreate(
            ['id' => $this->category_id ?? null],
            [
                'name' => strip_tags($this->name),
                'order' => strip_tags($this->order),
                'type' => strip_tags($this->type),
                'type' => strip_tags($this->type),
                'critical_deviation' => strip_tags($this->critical_deviation),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Category saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#category_modal');
    }
    public function onDelete($id)
    {
        $category = CategoryModel::find($id);
        $category->delete();
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
