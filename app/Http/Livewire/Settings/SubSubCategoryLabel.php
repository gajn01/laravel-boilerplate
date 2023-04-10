<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;

class SubSubCategoryLabel extends Component
{
    public $category_name;
    public $category_id;
    public $sub_category_id;
    public $sub_category_name;

    public function render()
    {
        return view('livewire.settings.sub-sub-category-label')->extends('layouts.app');
    }
    public function mount($category_id = null, $sub_category_id = null, $sub_sub_category_id = null)
    {
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;


        $category = CategoryModel::findOrFail($category_id);
        $category->name = $this->category_name;

        $sub_category_label = SubCategoryLabelModel::where('id', $sub_sub_category_id)->first();



    }
}
