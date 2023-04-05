<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;


class CategoryDetails extends Component
{
    public $category_name;
    public $category_type;
    public function render()
    {
        return view('livewire.settings.category-details')->extends('layouts.app');
    }
    public function mount($category_id = null)
    {
        $category = CategoryModel::find($category_id);
        $category->name = $this->category_name;
        $category->type = $this->category_type;
        dd( $category->type);
    }
}
