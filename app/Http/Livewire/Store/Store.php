<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;


class Store extends Component
{
    public $store_list = [];

    public function test(){
        dd($this->store_list);
    }
    public function render()
    {
        return view('livewire.store.store')->extends('layouts.app');
    }
    public function mount(){
        $this->store_list = StoreModel::all(['id','code', 'name', 'type', 'store_head', 'area'])->toArray();
    }
}
