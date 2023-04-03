<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class StoreSettings extends Component
{
    public $store_list = [];
    public $name;
    public $code;
    public $type;
    public $area;
    public $store_head;

    public function mount(){
    /*     $stores = Store::all();
        $this->store_list = $stores->map(function ($store) {
            return [
                'id' => $store->id,
                'name' => $store->name,
                'code' => $store->code,
                'type' => $store->type = $store->type == 1 ? 'Cafe' : 'Kiosk',
                'area' => $store->area,
                'store_head' => $store->store_head,
            ];
        }); */
    }

    public function render()
    {
        return view('livewire.settings.store-settings')->extends('layouts.app');
    }
}
