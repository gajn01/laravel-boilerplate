<?php

namespace App\Http\Livewire\Report;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\AuditFormResult as AuditFormResultModel;

class Aggregate extends Component
{
    public $category;
    public $limit = 10;
    public function render()
    {
        $category = CategoryModel::all()->unique('name');
        $query = AuditFormResultModel::query();
        $query->where(function ($q){
            $q->whereNotNull('sub_sub_remarks');
            $q->orWhereNotNull('sub_sub_deviation');

        });
        if ($this->category) {
            $query->where('category_name', $this->category);
        }
        $results = $query->paginate($this->limit);
        return view('livewire.report.aggregate', ['aggregate' => $results, 'categories' => $category])->extends('layouts.app');
    }
}
