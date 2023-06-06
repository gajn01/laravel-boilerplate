<?php

namespace App\Http\Livewire\Report;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Category as CategoryModel;

class Aggregate extends Component
{
    public $category;
    public $limit = 10;
    public function render()
    {

        $category = CategoryModel::all()->unique('name');
        $results_query = DB::table('audit_results')
            ->join('audit_forms', 'audit_results.form_id', '=', 'audit_forms.id')
            ->join('stores', 'audit_forms.store_id', '=', 'stores.id')
            ->select('audit_forms.store_id', 'stores.name', 'audit_results.*')
            ->whereNotNull('sub_sub_deviation');
        if ($this->category) {
            $results_query->where('audit_results.category_name', $this->category);
        }
        $results = $results_query
            ->paginate($this->limit);
        return view('livewire.report.aggregate', ['aggregate' => $results, 'categories' => $category])->extends('layouts.app');
    }
}
