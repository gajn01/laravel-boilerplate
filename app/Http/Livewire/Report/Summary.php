<?php

namespace App\Http\Livewire\Report;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\AuditFormResult as AuditFormResultModel;

class Summary extends Component
{
    public $category, $area,$store,$search,$wave;
    public $store_list;
    public $limit = 10;
    public function render()
    {
        $category = CategoryModel::all()->unique('name');
        $query = AuditFormResultModel::where(function ($q) {
            $q->whereNotNull('sub_sub_remarks');
            $q->orWhereNotNull('sub_sub_deviation');
        })
        ->when($this->search, function ($query) {
            $query->whereHas('forms.stores', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        })
        ->when($this->category != 'all' && $this->category != '', function ($query) {
            $query->where('category_name', $this->category);
        })
        ->when($this->area != 'all' && $this->area != '', function ($query) {
            $query->whereHas('forms.stores', function ($q) {
                $q->where('area', $this->area);
            });
        })
        ->when($this->wave != 'all' && $this->wave != '', function ($query) {
            $query->whereHas('forms', function ($q) {
                $q->where('wave', $this->wave);
            });
        });
        $results = $query->paginate($this->limit);
        return view('livewire.report.summary', ['aggregate' => $results, 'categories' => $category])->extends('layouts.app');
    }
    public function mount(){
        $this->store_list = StoreModel::all();
    }
}