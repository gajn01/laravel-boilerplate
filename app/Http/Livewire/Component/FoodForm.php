<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\DropdownMenu as DropdownMenuModel;



class FoodForm extends Component
{

    public $food = [];
    public $data = [];
    public $lcm = [];
    public $search1;
    public $search1_results;
    public $search1Value;
    public $test = 0;
    public function mount($data = null, $lcm = null)
    {
        $this->data = $data;
        $this->lcm = $lcm;
    }
    public function render()
    {

        return view('livewire.component.food-form');

    }

}
