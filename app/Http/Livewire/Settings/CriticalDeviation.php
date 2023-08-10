<?php

namespace App\Http\Livewire\Settings;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Models\CriticalDeviation as CriticalDeviationModel;
use App\Helpers\ActivityLogHelper;


use Livewire\Component;

class CriticalDeviation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $name;
    public $critical_deviation_id;
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
        if (!Gate::allows('allow-view', 'module-critical-deviation-management')) {
            return redirect()->route('dashboard');
        }
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $data = CriticalDeviationModel::select('id', 'name')
            ->where('name', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.critical-deviation', ['deviation_list' => $data])->extends('layouts.app');
    }
    public function showModal($id = null)
    {
        $data = CriticalDeviationModel::find($id);
        $this->name = optional($data)->name;
        $this->critical_deviation_id = $id;
        $this->modalTitle = $this->critical_deviation_id ? 'Edit Critical Deviation' : 'Add Critical Deviation';
        $this->modalButtonText = $this->critical_deviation_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->critical_deviation_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-critical-deviation-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->validate(
            [
                'name' => 'required',
            ]
        );
        CriticalDeviationModel::updateOrCreate(
            ['id' => $this->critical_deviation_id ?? null],
            [
                'name' => strip_tags($this->name),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Critical deviation saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#critical_deviation_menu_modal');
        $action = $this->critical_deviation_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Critical Deviation', $this->critical_deviation_id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-critical-deviation-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $data = CriticalDeviationModel::find($id);
        $data->delete();
        $this->activity->onLogAction('delete','Critical Deviation', $this->critical_deviation_id ?? null);

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
