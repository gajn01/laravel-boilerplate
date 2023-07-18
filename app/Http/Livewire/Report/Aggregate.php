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
        $category = CategoryModel::all()->unique('name');
        $this->aggregate_list = CategoryModel::pluck('name')->unique()->toArray();
        $restructured_data = $category->map(fn($item, $key) => ['category_name' => $item->name, 'data' => []])->toArray();
        
        $aggregate = AuditFormResultModel::where(function ($q) {
                $q->whereNotNull('sub_sub_remarks')
                    ->orWhereNotNull('sub_sub_deviation')
                    ->orWhereNotNull('label_remarks')
                    ->orWhereNotNull('label_deviation');
            })
            ->when($this->search, fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')))
            ->when($this->area && $this->area !== 'all', fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('area', $this->area)))
            ->when($this->wave && $this->wave !== 'all', fn($query) => $query->whereHas('forms', fn($q) => $q->where('wave', $this->wave)))
            ->when($this->category && $this->category !== 'all', fn($query) => $query->where('category_name', $this->category))
            ->get();
        
        // Grouping the results by category_name
        $groupedData = $aggregate->groupBy('category_name');
        foreach ($groupedData as $categoryName => $categoryData) {
            $categoryResult = $restructured_data[array_search($categoryName, array_column($restructured_data, 'category_name'))];
            $deviationRemarks = $categoryData->filter(function ($item) {
                return $item->sub_sub_remarks || $item->sub_sub_deviation || $item->label_remarks || $item->label_deviation;
            });
        
            $storesWithDeviationsRemarks = $deviationRemarks->groupBy('store_id');
            // dd($categoryData);

        
            $categoryResult['data'] = $deviationRemarks;
            $categoryResult['stores'] = $storesWithDeviationsRemarks;
        
            $restructured_data[array_search($categoryName, array_column($restructured_data, 'category_name'))] = $categoryResult;
        }
        
        // Here, $restructured_data will contain the desired data structure
        

        return view('livewire.report.aggregate', ['aggregate' => $aggregate, 'categories' => $category,'test'=>$category])->extends('layouts.app');
    }
}