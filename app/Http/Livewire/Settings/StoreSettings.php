<?php
namespace App\Http\Livewire\Settings;
use Livewire\Component;
use App\Models\Store as StoreModel;
class StoreSettings extends Component
{
    protected $listeners = ['alert-sent' => 'onAlertSent'];
    public $store_list = [];
    public $store_id;
    public $name;
    public $code;
    public $type;
    public $area;
    public $store_head;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public function mount()
    {
        $this->store_list = StoreModel::all(['id','code', 'name', 'type', 'store_head', 'area'])->toArray();
    }
    public function render()
    {
        return view('livewire.settings.store-settings')->extends('layouts.app');
    }
    public function onSearch()
    {
        $this->store_list = StoreModel::where('code', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('name', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('store_head', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('area', 'like', '%'.$this->searchTerm.'%')
            ->orWhere('type', $this->searchTerm)
            ->get(['id', 'code', 'name', 'type', 'store_head', 'area'])
            ->toArray();
    }
    public function showModal($store_id = null)
    {
        $store = StoreModel::find($store_id);
        $this->name =  optional($store)->name;
        $this->code =  optional($store)->code;
        $this->type =  optional($store)->type;
        $this->area =  optional($store)->area;
        $this->store_head =  optional($store)->store_head;

        $this->resetValidation();
        $this->resetValidation();
        $this->store_id = $store_id;
        $this->modalTitle = $this->store_id ? 'Edit Store' : 'Add Store';
        $this->modalButtonText = $this->store_id ? 'Update' : 'Add';
        $this->dispatchBrowserEvent('show-item-form');
    }
    public function onSave()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'code' => 'required' ,
                'type' => 'required|in:0,1',
                'area' => 'required|in:MFO,South,North',
            ]
        );
        StoreModel::updateOrCreate(
            ['id' => $this->store_id ?? null],
            [
                'name' => strip_tags($this->name),
                'code' => strip_tags($this->code),
                'store_head' => strip_tags($this->store_head),
                'type' => strip_tags($this->type),
                'area' => strip_tags($this->area),
            ]
        );
        $this->reset();
        $this->store_list = StoreModel::all(['id','code', 'name', 'type', 'store_head', 'area'])->toArray();
        $this->onAlert(false, 'Success', 'Store saved successfully!', 'success');
        $this->dispatchBrowserEvent('remove-modal',['modalName' => '#store_modal']);
        $this->emit('saved');
    }
    public function onDelete($store_id)
    {
        $store = StoreModel::find($store_id);
        $store->delete();
        $this->store_list = StoreModel::all(['id','code', 'name', 'type', 'store_head', 'area'])->toArray();
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
        $this->code = '';
        $this->store_id = '';
        $this->store_head = '';
        $this->area = '';
        $this->type = '';
        $this->resetValidation();
    }
    public function onAlertSent($data)
    {
        $this->onDelete($data);
    }
}
