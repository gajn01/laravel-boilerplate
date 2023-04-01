<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;

class ExecutiveSummary extends Component
{
    public function render()
    {
        return view('livewire.store.executive-summary')->extends('layouts.app');
    }
}
