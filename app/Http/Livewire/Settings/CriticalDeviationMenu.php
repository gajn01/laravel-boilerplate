<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\CriticalDeviation as CriticalDeviationModel;
use App\Models\Dropdown as DropdownModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Helpers\ActivityLogHelper;


class CriticalDeviationMenu extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $deviation;
    public $critical_deviation_menu_id;
    public $label;
    public $is_sd;
    public $remarks;
    public $is_location;
    public $location_dropdown_id;
    public $is_product;
    public $product_dropdown_id;
    public $is_dropdown;
    public $dropdown_id;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount($critical_deviation_id = null)
    {
        if (!Gate::allows('allow-view', 'module-critical-deviation-management')) {
            return redirect()->route('dashboard');
        }
        $this->deviation = CriticalDeviationModel::find($critical_deviation_id);
    }
    public function render()
    {
        $dropdown = DropdownModel::select('id', 'name')->get();
        $searchTerm = '%' . $this->searchTerm . '%';
        $data = CriticalDeviationMenuModel::select('id', 'critical_deviation_id', 'label', 'remarks', 'score_dropdown_id', 'is_sd', 'is_dropdown', 'dropdown_id')
            ->where('critical_deviation_id', $this->deviation->id)
            ->where('label', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.critical-deviation-menu', ['deviation_list' => $data, 'dropdown_list' => $dropdown])->extends('layouts.app');
    }
    public function showModal($id = null)
    {
        $data = CriticalDeviationMenuModel::find($id);
        $this->label = optional($data)->label;
        $this->remarks = optional($data)->remarks;
        $this->is_sd = optional($data)->is_sd;
        $this->is_location = optional($data)->is_location;
        $this->location_dropdown_id = optional($data)->location_dropdown_id;
        $this->is_product = optional($data)->is_product;
        $this->product_dropdown_id = optional($data)->product_dropdown_id;
        $this->is_dropdown = optional($data)->is_dropdown;
        $this->dropdown_id = optional($data)->dropdown_id;
        $this->critical_deviation_menu_id = $id;
        $this->modalTitle = $this->critical_deviation_menu_id ? 'Edit Critical Deviation ' : 'Add Critical Deviation ';
        $this->modalButtonText = $this->critical_deviation_menu_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->critical_deviation_menu_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-critical-deviation-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }

        $this->validate([
            'label' => 'required',
            'remarks' => 'nullable|boolean',
            'is_sd' => 'nullable|boolean',
            'is_location' => 'nullable|boolean',
            'location_dropdown_id' => 'nullable',
            'is_product' => 'nullable|boolean',
            'product_dropdown_id' => 'nullable',
            'is_dropdown' => 'nullable|boolean',
            'dropdown_id' => 'nullable',
        ]);
        CriticalDeviationMenuModel::updateOrCreate(
            ['id' => $this->critical_deviation_menu_id ?? null],
            [
                'critical_deviation_id' => $this->deviation->id,
                'label' => strip_tags($this->label),
                'remarks' => $this->remarks ?? false,
                'is_sd' => $this->is_sd ?? false,
                'is_location' => $this->is_location ?? false,
                'location_dropdown_id' => $this->location_dropdown_id ?? 0,
                'is_product' => $this->is_product ?? false,
                'product_dropdown_id' => $this->product_dropdown_id ?? 0,
                'is_dropdown' => $this->is_dropdown ?? false,
                'dropdown_id' => $this->dropdown_id ?? 0,
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Critical deviation saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#critical_deviation_menu_modal');
        $action = $this->critical_deviation_menu_id ?  'update' : 'create';
        $this->activity->onLogAction($action,'Critical Deviation menu', $this->critical_deviation_menu_id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-critical-deviation-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $data = CriticalDeviationMenuModel::find($id);
        $data->delete();
        $this->activity->onLogAction('delete','Critical Deviation menu', $this->critical_deviation_menu_id ?? null);

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
