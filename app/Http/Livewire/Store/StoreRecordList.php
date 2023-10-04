<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\AuditForm;
use App\Models\Summary;

class StoreRecordList extends Component
{
    public function render()
    {
        $storeRecord = $this->getStoreRecordList();
        return view('livewire.store.store-record-list', ['storeRecord' => $storeRecord])->extends('layouts.app');
    }

    public function getStoreRecordList()
    {
        return AuditForm::where('store_id', auth()->user()->name)->get();
    }
}