<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;

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
    public function mount($category_id = null)
    {
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
        $this->onAlert(false, 'Success', 'Sub category saved successfully!','', 'success');
        CustomHelper::onRemoveModal($this, '#sub_category_label_modal');
    }
    public function onDelete($id)
    {
        $sub_category = SubCategoryModel::find($id);
        $sub_category->delete();
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $confirm_message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message,$confirm_message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }

}
