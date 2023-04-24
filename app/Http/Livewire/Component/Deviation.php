<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;
use App\Models\SanitaryModel as SanitaryModel;


class Deviation extends Component
{
    public $f_major_sd = [];
    public $f_product;
    public function render()
    {
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();
        return view('livewire.component.deviation',['sanitation_list'=> $sanitation_defect])->extends('layouts.app');
    }
}
