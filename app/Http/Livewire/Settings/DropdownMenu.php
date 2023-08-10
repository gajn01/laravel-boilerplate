<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Dropdown as DropdownModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;

class DropdownMenu extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $dropdown_id;
    public $dropdown_name;
    public $dropdown_menu_id;
    public $name;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount($dropdown_id = null)
    {
        if (!Gate::allows('allow-view', 'module-dropdown-management')) {
            return redirect()->route('dashboard');
        }
        $this->dropdown_id = $dropdown_id;
        $this->dropdown_name = DropdownModel::find($dropdown_id)->name;
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $dropdown_menu_list = DropdownMenuModel::select('id', 'name', 'dropdown_id')
            ->where('dropdown_id', $this->dropdown_id)
            ->where('name', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.dropdown-menu', ['dropdown_menu_list' => $dropdown_menu_list])->extends('layouts.app');
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->dropdown_menu_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-dropdown-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }

        $this->validate(
            [
                'name' => 'required',
            ]
        );
        DropdownMenuModel::updateOrCreate(
            ['id' => $this->dropdown_menu_id ?? null],
            [
                'dropdown_id' => $this->dropdown_id,
                'name' => strip_tags($this->name),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Dropdown menu saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#dropdown_menu_modal');
        $action = $this->dropdown_menu_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Dropdown menu', $this->dropdown_menu_id ?? null);
    }
    public function showModal($dropdown_menu_id = null)
    {
        $dropdown = DropdownMenuModel::find($dropdown_menu_id);
        $this->name = optional($dropdown)->name;
        $this->resetValidation();
        $this->dropdown_menu_id = $dropdown_menu_id;
        $this->modalTitle = $this->dropdown_menu_id ? 'Edit Dropdown' : 'Add Dropdown';
        $this->modalButtonText = $this->dropdown_menu_id ? 'Update' : 'Add';
    }
    public function onDelete($dropdown_menu_id)
    {
        if(!Gate::allows('allow-delete','module-dropdown-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $dropdown = DropdownMenuModel::find($dropdown_menu_id);
        $dropdown->delete();
        $this->activity->onLogAction('delete','Dropdown menu', $this->dropdown_menu_id ?? null);

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
