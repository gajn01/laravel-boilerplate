<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;

class Category extends Component
{
    public $category_list = [];

    public function render()
    {
        return view('livewire.settings.category')->extends('layouts.app');
    }
    public function mount()
    {
        $this->category_list = CategoryModel::all(['id','name', 'type'])->toArray();
    }
}
