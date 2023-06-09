<?php

namespace App\Http\Livewire\Store;

use App\Models\auditor_list;
use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\User as UserModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\auditor_list as AuditorListModel;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Store extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $store_id;
    public $name;
    public $code;
    public $type;
    public $area;
    public $representative;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $store_list = StoreModel::where('name', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->orWhere('area', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('code', 'ASC')
            ->paginate($this->limit);
        return view('livewire.store.store', ['store_list' => $store_list])->extends('layouts.app');
    }
    public function showModal($store_id = null)
    {
        $store = StoreModel::find($store_id);
        $this->name = optional($store)->name;
        $this->code = optional($store)->code;
        $this->type = optional($store)->type;
        $this->area = optional($store)->area;
        $this->resetValidation();
        $this->store_id = $store_id;
        $this->modalTitle = $this->store_id ? 'Edit Store' : 'Add Store';
        $this->modalButtonText = $this->store_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'code' => 'required',
                'type' => 'required|in:0,1',
                'area' => 'required|in:MFO,South,North',
            ]
        );
        StoreModel::updateOrCreate(
            ['id' => $this->store_id ?? null],
            [
                'name' => strip_tags($this->name),
                'code' => strip_tags($this->code),
                'type' => strip_tags($this->type),
                'area' => strip_tags($this->area),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Store saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#store_modal');
    }
    public function onDelete($store_id)
    {
        $store = StoreModel::find($store_id);
        $store->delete();
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
