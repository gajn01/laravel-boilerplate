<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
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
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $category_list = CategoryModel::select('id', 'name','type')
            ->where('name', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.category', ['category_list' => $category_list])->extends('layouts.app');
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
        $this->resetValidation();
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
