<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;

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
        $this->store_list=[
            [
                'id' => 1,
                'name' => 'Serendra',
                'code' => 'C001',
                'wave1'   => 'Uncompleted',
                'wave2'   => 'Uncompleted',
            ],[
                'id' => 2,
                'name' => 'Trinoma',
                'code' => 'C002',
                'wave1'   => 'Uncompleted',
                'wave2'   => 'Uncompleted',
            ],[
                'id' => 3,
                'name' => 'Alabang Town Center',
                'code' => 'C003',
                'wave1'   => 'Uncompleted',
                'wave2'   => 'Uncompleted',
            ],[
                'id' => 4,
                'name' => 'ROCKWELL BUSINESS CENTER',
                'code' => 'C004',
                'wave1'   => 'Uncompleted',
                'wave2'   => 'Uncompleted',
            ],[
                'id' => 5,
                'name' => 'GREENBELT 2',
                'code' => 'C005',
                'wave1'   => 'Uncompleted',
                'wave2'   => 'Uncompleted',
            ],
        ];

    }
}
