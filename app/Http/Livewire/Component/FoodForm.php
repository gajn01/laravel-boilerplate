<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;



class FoodForm extends Component
{

    public $food = [];
    public $data = [];
    public $lcm = [];
    public $search1;
    public $search1_results;
    public $search1Value;
    public $test = 'check';
    public function mount($data = null, $lcm = null)
    {
        $this->data = $data;
        $this->lcm = $lcm;

        $food_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
            'category',
        ])->where('category_id', 2)->get();
        $this->food = [
            [
                'data_items' => $food_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' =>
                        $subCategory->subCategoryLabels->map(function ($label) {

                                    return [
                                        'id' => $label->id,
                                        'name' => $label->name,
                                        'bp' => $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*',
                                        'points' => '',
                                        'remarks' => '',
                                        'tag' => '',
                                        'dropdown'=> [
                                             SubCategoryModel::where('category_id', 1)->get()->toArray()
                                        ]
                                    ];
                                })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];


    }
    public function onSearchDropdown()
    {
        $this->search1_results = SubCategoryModel::select('name')->where('name', 'LIKE', '%' . $this->search1Value . '%')->get()->toArray();

    }
    public function render()
    {

        return view('livewire.component.food-form');

    }

}
