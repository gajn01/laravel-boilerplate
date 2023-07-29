<?php
namespace App\Http\Livewire\Settings;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;
use App\Models\Dropdown as DropdownModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
class SubCategoryLabel extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;
    public $label_id;
    public $name;
    public $is_all_nothing = false;
    public $bp;
    public $is_sub = false;
    public $dropdown_list;
    public $dropdown_id;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function mount($category_id = null, $sub_category_id = null)
    {

        if (!Gate::allows('allow-view', 'module-category-management')) {
            return redirect()->route('dashboard');
        }
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->category_name = CategoryModel::where('id', $category_id)->value('name');
        $sub_category = SubCategoryModel::find($sub_category_id);
        $this->sub_category_name = optional($sub_category)->name;
        $this->is_sub = optional($sub_category)->is_sub ?? 0;
        $this->dropdown_list = DropdownModel::get();
       /*  $this->dropdown_list = cache()->remember('dropdown_list', 60, function () {
            return DropdownModel::get()->toArray();
        }); */
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $label_list = SubCategoryLabelModel::select('id', 'name', 'sub_category_id', 'bp', 'is_all_nothing','dropdown_id')
            ->where('sub_category_id', $this->sub_category_id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->paginate($this->limit);
        return view('livewire.settings.sub-category-label', ['label_list' => $label_list])->extends('layouts.app');
    }

    public function showModal($label_id = null)
    {
        $label = SubCategoryLabelModel::find($label_id);
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
        SubCategoryLabelModel::updateOrCreate(
            ['id' => $this->label_id],
            [
                'name' => $this->name,
                'sub_category_id' => $this->sub_category_id,
                'is_all_nothing' => $this->is_sub == 0 ? $this->is_all_nothing : 0,
                'bp' => $this->is_sub == 0 ? $this->bp : 0,
                'dropdown_id' => $this->is_sub == 0 ? $this->dropdown_id : '0',
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#label_modal');
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-category-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $sub_category = SubCategoryLabelModel::find($id);
        $sub_category->delete();
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
