<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use Livewire\WithPagination;
class Store extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $searchTerm;
    public $limit = 10;
    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $store_list = StoreModel::select('id', 'code', 'name', 'type', 'area')
            ->where('name', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->orWhere('area', 'like', '%' . $this->searchTerm . '%')
            ->paginate($this->limit);
        return view('livewire.store.store', ['store_list' => $store_list])->extends('layouts.app');
    }
}
