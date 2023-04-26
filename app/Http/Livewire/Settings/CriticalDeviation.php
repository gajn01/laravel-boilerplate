<?php

namespace App\Http\Livewire\Settings;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use App\Models\CriticalDeviation as CriticalDeviationModel;

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
