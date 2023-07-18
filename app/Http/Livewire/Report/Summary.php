<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use Livewire\WithPagination;

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
        $summary = AuditFormResultModel::where(fn ($q) =>
            $q->whereNotNull('sub_sub_remarks')
                ->orWhereNotNull('sub_sub_deviation')
                ->orWhereNotNull('label_remarks')
                ->orWhereNotNull('label_deviation'))
            ->when($this->search, fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('name', 'like', '%' . $this->search . '%')))
            ->when($this->area && $this->area !== 'all', fn($query) => $query->whereHas('forms.stores', fn($q) => $q->where('area', $this->area)))
            ->when($this->wave && $this->wave !== 'all', fn($query) => $query->whereHas('forms', fn($q) => $q->where('wave', $this->wave)))
            ->when($this->category && $this->category !== 'all', fn($query) => $query->where('category_name', $this->category))
            ->paginate($this->limit);
        return view('livewire.report.summary', ['summary' => $summary, 'categories' => $category])->extends('layouts.app');
    }
    public function mount()
    {
        $this->store_list = StoreModel::all();
    }
}