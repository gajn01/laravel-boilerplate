<?php
namespace App\Http\Livewire\Settings;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;
class SubCategoryLabel extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;
    public $label_list = [];
    public $label_id;
    public $name;
    public $is_all_nothing = false;
    public $bp;
    public $is_sub = false;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function render()
    {
        return view('livewire.settings.sub-category-label')->extends('layouts.app');
    }
    public function mount($category_id = null, $sub_category_id = null)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $data = DB::table('categories')
            ->join('sub_categories', 'categories.id', '=', 'sub_categories.category_id')
            ->join('sub_categories_label', 'sub_categories.id', '=', 'sub_categories_label.sub_category_id')
            ->select(
                'categories.name as category_name',
                'sub_categories.name as sub_category_name',
                'sub_categories.is_sub',
                'sub_categories_label.*'
            )
            ->where('categories.id', '=', $category_id)
            ->where('sub_categories.id', '=', $sub_category_id)
            ->get();

        $this->category_name = $data[0]->category_name;
        $this->sub_category_name = $data[0]->sub_category_name;
        $this->is_sub = $data[0]->is_sub;
        $this->label_list = json_decode(json_encode($data->toArray()), true);
    }
    public function showModal($label_id = null)
    {
        $label = SubCategoryLabelModel::find($label_id);
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
        SubCategoryLabelModel::updateOrCreate(
            ['id' => $this->label_id],
            [
                'name' => $this->name,
                'sub_category_id' => $this->sub_category_id,
                'is_all_nothing' => $this->is_sub == 0 ? $this->is_all_nothing : 0,
                'bp' => $this->is_sub == 0 ? $this->bp : 0,
            ]
        );
        $this->reset();
        $this->label_list = SubCategoryLabelModel::where('sub_category_id', $this->sub_category_id)->get()->toArray();
        $this->onAlert(false, 'Success', 'Label saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal', ['modalName' => '#label_modal']);
        $this->emit('saved');
    }
    public function onSearch()
    {
        $query = SubCategoryLabelModel::select('id', 'name', 'sub_category_id', 'is_all_nothing', 'bp')
            ->where('sub_category_id', $this->sub_category_id);
        if ($this->searchTerm) {
            $query->where('name', 'like', '%' . $this->searchTerm . '%');
        }
        $this->label_list = $query->get(['id', 'name', 'sub_category_id', 'is_all_nothing', 'bp'])->toArray();
    }
    public function onDelete($id)
    {
        $store = SubCategoryLabelModel::find($id);
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
