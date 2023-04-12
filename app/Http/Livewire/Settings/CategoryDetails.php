<?php
namespace App\Http\Livewire\Settings;
use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
class CategoryDetails extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $category_id;
    public $category_name;
    public $sub_category_list;
    public $sub_category_id;
    public $sub_category_name;
    public $is_sub = false;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function render()
    {
        return view('livewire.settings.category-details')->extends('layouts.app');
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
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function mount($category_id = null)
    {
        $this->category_id = $category_id;
        $category = CategoryModel::with('subCategories')->where('id', $category_id)->first();
        $this->category_name = $category->name;
        $this->sub_category_list = $category->subCategories->toArray();
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
        $this->sub_category_list = SubCategoryModel::where('category_id', $this->category_id)->get()->toArray();
        $this->onAlert(false, 'Success', 'Sub category saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#sub_category_label_modal']);
        $this->emit('saved');

    }
    public function onSearch()
    {
        $query = SubCategoryModel::select('id', 'name', 'category_id', 'is_sub')
            ->where('category_id', $this->category_id);
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        $this->sub_category_list = $query->get(['id', 'name', 'category_id', 'is_sub'])->toArray();
    }
    public function onDelete($id)
    {
        $sub_category = SubCategoryModel::find($id);
        $sub_category->delete();
        $this->sub_category_list = array_values(array_filter($this->sub_category_list, function ($sub) use ($id) {
            return $sub['id'] != $id;
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
        $this->sub_category_name = '';
        $this->sub_category_id = '';
        $this->is_sub = false;
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
