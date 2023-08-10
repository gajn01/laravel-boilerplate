<?php
namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Dropdown as DropdownModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;

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
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount(){
        if (!Gate::allows('allow-view', 'module-dropdown-management')) {
            return redirect()->route('dashboard');
        }
    }
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
        $access = 'allow-create';
        if($this->dropdown_id){
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
        DropdownModel::updateOrCreate(
            ['id' => $this->dropdown_id ?? null],
            [
                'name' => strip_tags($this->name),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Dropdown saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#dropdown_modal');
        $action = $this->dropdown_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Dropdown', $this->dropdown_id ?? null);

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
        if(!Gate::allows('allow-delete','module-dropdown-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $dropdown = DropdownModel::find($dropdown_id);
        $dropdown->delete();
        $this->activity->onLogAction('delete','Dropdown', $this->dropdown_id ?? null);

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
