<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\CriticalDeviation as CriticalDeviationModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;

class CriticalDeviationMenu extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $deviation;
    public $critical_deviation_menu_id;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function mount($critical_deviation_id = null)
    {
        $this->deviation = CriticalDeviationModel::find($critical_deviation_id);
    }
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $data = CriticalDeviationMenuModel::select('id', 'critical_deviation_id', 'label', 'remarks', 'score_dropdown_id', 'is_sd', 'is_dropdown', 'dropdown_id')
            ->where('label', 'like', $searchTerm)
            ->paginate($this->limit);
        return view('livewire.settings.critical-deviation-menu', ['deviation_list' => $data])->extends('layouts.app');
    }
    public function showModal($id = null)
    {
        $data = CriticalDeviationModel::find($id);

        $this->critical_deviation_menu_id = $id;
        $this->modalTitle = $this->critical_deviation_menu_id ? 'Edit Sanitation Defect' : 'Add Sanitation Defect';
        $this->modalButtonText = $this->critical_deviation_menu_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required',
            ]
        );
        CriticalDeviationModel::updateOrCreate(
            ['id' => $this->critical_deviation_menu_id ?? null],
            [
                'name' => strip_tags($this->name),
            ]
        );
        $this->reset();
        $this->onAlert(false, 'Success', 'Critical deviation saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#critical_deviation_menu_modal');
    }
    public function onDelete($id)
    {
        $data = CriticalDeviationModel::find($id);
        $data->delete();
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
