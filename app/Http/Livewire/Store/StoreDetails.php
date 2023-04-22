<?php
namespace App\Http\Livewire\Store;
use Livewire\Component;
use App\Models\Store as StoreModel;
class StoreDetails extends Component
{
    public $store_id;
    public $store;
    public function mount($store_id = null)
    {
        $this->store_id = $store_id;
        $this->store = StoreModel::find($store_id);
    }
    public function render()
    {
        return view('livewire.store.store-details')->extends('layouts.app');
    }
}
