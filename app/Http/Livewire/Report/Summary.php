<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;

class Summary extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $category, $area, $store, $search, $wave, $type;
    public $store_list;
    public $limit = 10;
    public function render()
    {
        $category = CategoryModel::all()->unique('name');
        $summary = $this->getSummaryList();
        return view('livewire.report.summary', ['summary' => $summary, 'categories' => $category])->extends('layouts.app');
    }
    public function getSummaryList(){
        return AuditFormResultModel::where(fn($query) =>
        $query->whereHas('forms.date', fn($q) =>
            $q->where('is_complete', '2')))
        ->where(fn($q) =>
            $q->whereNotNull('sub_sub_remarks')
                ->orWhereNotNull('sub_sub_deviation')
                ->orWhereNotNull('label_remarks')
                ->orWhereNotNull('label_deviation'))
        ->when($this->search, fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')))
        ->when($this->area && $this->area !== 'all', fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('area', $this->area)))
        ->when($this->wave && $this->wave !== 'all', fn($query) => $query->whereHas('forms', fn($q) => $q->where('wave', $this->wave)))
        ->when($this->category && $this->category !== 'all', fn($query) => $query->where('category_name', $this->category))
        ->paginate($this->limit);
    }
    public function exportCSV(){
        $summary_list = $this->getSummaryList();
        $csvData = [];
        $csvData[] = ['Area', 'Store Name', 'ROS', 'Category', 'Sub-Category', 'Specific', 'Deviation Details', 'Remarks','Additional Info','Year','Wave']; 
        foreach ($summary_list as $summary) {
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