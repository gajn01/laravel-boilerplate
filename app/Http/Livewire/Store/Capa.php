<?php

namespace App\Http\Livewire\Store;
use Livewire\WithFileUploads;
use Livewire\Component;
use League\Csv\Reader;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Gate;
use App\Models\Capa as CapaModel;
class Capa extends Component
{
   
    public $displayPage = 10;
    public function render()
    {
        $capaList = $this->getDataList();
        return view('livewire.store.capa',['capaList' => $capaList])->extends('layouts.app');
    }
    public function mount()
    {
     
    }
    public function getDataList(){
        return CapaModel::paginate($this->displayPage);
    }
}
