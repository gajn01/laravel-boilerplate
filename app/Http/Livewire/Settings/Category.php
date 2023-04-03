<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class Category extends Component
{
    public $category_list = [];

    public function render()
    {
        return view('livewire.settings.category')->extends('layouts.app');
    }
    public function mount()
    {
        $this->category_list=[
            [
                'id' => 1,
                'name' => 'Food',
            ],[
                'id' => 2,
                'name' => 'Service',
            ],[
                'id' => 3,
                'name' => 'Production Process',
            ],[
                'id' => 4,
                'name' => 'Cleanliness and Condition',
            ],[
                'id' => 5,
                'name' => 'Document',
            ],[
                'id' => 5,
                'name' => 'People',
            ]
        ];
    }
}
