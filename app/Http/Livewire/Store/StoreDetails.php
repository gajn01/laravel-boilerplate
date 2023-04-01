<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;

class StoreDetails extends Component
{
    public $store_name;

    public function mount($store_name = null)
    {
        $this->store_name = $store_name;
    }

    public function render()
    {
        return view('livewire.store.store-details')->extends('layouts.app');
    }
}
