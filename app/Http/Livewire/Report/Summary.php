<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory;
use App\Models\SubCategoryLabel;
use App\Models\AuditFormResult as AuditFormResultModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;

class Summary extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category, $subCategory,$subSubCategory,$area, $store, $search, $wave, $type;
    public $store_list;
    public $limit = 10;
    public function render()
    {
        $category = CategoryModel::all()->unique('name');
        $summary = $this->getSummaryList();
        $subCategoryList = $this->getSubCategory($this->category);
        $subSubCategoryList = $this->getSubSubCategory($this->subCategory);
        return view('livewire.report.summary', ['total'=>$summary['totalResults'],'summary' => $summary['results'], 'categories' => $category,'subCategoryList'=> $subCategoryList,'subSubCategoryList'=> $subSubCategoryList ])->extends('layouts.app');
    }
    public function getSummaryList()
    {
        /* if($this->category == 'all'){
            $this->subCategory = 'all';
            $this->subSubCategory = 'all';
        } */
        $query = AuditFormResultModel::whereHas('forms', fn ($q) =>
            $q->where('audit_status', '2')
                ->when($this->area && $this->area !== 'all', fn ($q) => $q->where('area', $this->area))
                ->when($this->wave && $this->wave !== 'all', fn ($q) => $q->where('wave', $this->wave))
        )
        ->where(fn ($q) =>
            $q->whereNotNull('sub_sub_remarks')
                ->orWhereNotNull('sub_sub_deviation')
                ->orWhereNotNull('label_remarks')
                ->orWhereNotNull('label_deviation')
        )
        ->when($this->search, fn ($q) => $q->whereHas('forms.stores', fn ($q) => $q->where('name', 'like', '%' . $this->search . '%')))
        ->when($this->category && $this->category !== 'all', fn ($q) => $q->where('category_id', $this->category))
        ->when($this->subCategory && $this->subCategory !== 'all', fn ($q) => $q->where('sub_category_id', $this->subCategory))
        ->when($this->subSubCategory && $this->subSubCategory !== 'all', fn ($q) => $q->where('sub_sub_category_id', $this->subSubCategory));
        $totalResults = $query->count();
        $results = $query->paginate($this->limit);
        return ['totalResults' => $totalResults, 'results' => $results];
    }
    public function getSubCategory($category_id){
        return SubCategory::where('category_id', $category_id)->get();
    }
    public function getSubSubCategory($sub_category_id){
        return SubCategoryLabel::where('sub_category_id', $sub_category_id)->get();
    }
    public function exportCSV(){
        $summary_list = $this->getSummaryList();
        $csvData = [];
        $csvData[] = ['Area', 'Store Name', 'ROS', 'Category', 'Sub-Category', 'Specific', 'Deviation Details', 'Remarks','Additional Info','Year','Wave']; 
        foreach ($summary_list['results'] as $summary) {
            $csvData[] = [
                $summary->forms->stores->area,
                $summary->forms->stores->name,
                $summary->category->ros == 0 ? 'Primary' : 'Secondary',
                $summary->category_name,
                $summary->sub_name,
                $summary->sub_sub_name,
                $summary->label_name,
                $summary->sub_sub_remarks ? $summary->sub_sub_remarks : $summary->label_remarks ,
                $summary->sub_sub_deviation ? $summary->sub_sub_deviation : $summary->label_deviation,
                date('Y', strtotime($summary->updated_at)) ,
                $summary->forms->wave,
            ];
        }
        $fileName = 'summary_data_' . date('m-d-Y') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
        return Response::stream(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 200, $headers);
    }
    public function mount()
    {
        $this->store_list = StoreModel::all();
    }
}