<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Dropdown as DropdownModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;

class Dropdown extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $dropdown_id;
    public $name;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $dropdown_list = DropdownModel::select('id', 'name')
            ->where('name', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.dropdown', ['dropdown_list' => $dropdown_list])->extends('layouts.app');
    }
    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required',
            ]
        );
        DropdownModel::updateOrCreate(
            ['id' => $this->dropdown_id ?? null],
            [
                'name' => strip_tags($this->name),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Dropdown saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#dropdown_modal');
    }
    public function showModal($dropdown_id = null)
    {
        $dropdown = DropdownModel::find($dropdown_id);
        $this->name = optional($dropdown)->name;
        $this->resetValidation();
        $this->dropdown_id = $dropdown_id;
        $this->modalTitle = $this->dropdown_id ? 'Edit Dropdown' : 'Add Dropdown';
        $this->modalButtonText = $this->dropdown_id ? 'Update' : 'Add';
    }
    public function onDelete($dropdown_id)
    {
        $dropdown = DropdownModel::find($dropdown_id);
        $dropdown->delete();
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
