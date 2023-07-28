<?php

namespace App\Http\Livewire\Report;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use Livewire\WithPagination;


class Aggregate extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category, $area, $store, $search, $wave, $type;
    public $aggregate_list = [];
    public $limit = 10;
    public function render()
    {
        $category_names = CategoryModel::distinct('name')->get(['name'])->pluck('name')->toArray();
        $restructured_data = array_map(fn($name) => ['category_name' => $name, 'data' => [], 'score' => null], $category_names);
        $aggregate = AuditFormResultModel::where(fn($q) =>
            $q->whereNotNull('sub_sub_remarks')
                ->orWhereNotNull('sub_sub_deviation')
                ->orWhereNotNull('label_remarks')
                ->orWhereNotNull('label_deviation'))
            ->when($this->category && $this->category !== 'all', fn($query) => $query->where('category_name', $this->category))
            ->get();
        $score = DB::table('audit_results')
            ->select('category_id', 'category_name')
            ->selectRaw('COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0) AS total_base_points')
            ->selectRaw('COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0) AS total_points')
            ->selectRaw('ROUND((COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0)) / (COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0)) * 100, 2) AS percentage')
            ->groupBy('category_id', 'category_name')
            ->get();
        foreach ($aggregate as $agg) {
            $index = array_search($agg->category_name, $category_names);
            if ($index !== false) {
                $restructured_data[$index]['data'][] = [
                    'deviation' => $agg->sub_name,
                    'remarks' => $agg->sub_sub_remarks ? $agg->sub_sub_remarks : $agg->label_remarks,
                    'details' => $agg->sub_sub_deviation ? $agg->sub_sub_deviation : $agg->label_deviation,
                    'store' => optional($agg->forms)->stores->name,
                ];
            }
        }
        foreach ($score as $value) {
            $index = array_search($value->category_name, $category_names);
            if ($index !== false) {
                $restructured_data[$index]['score'] = $value->percentage;
            }
        }
        // dd($restructured_data);
        $restructured_data = array_filter($restructured_data, fn($item) => !empty($item['data']) || !empty($item['store']));
        return view('livewire.report.aggregate', ['aggregate' => $restructured_data, 'categories' => $category_names])->extends('layouts.app');
    }
}