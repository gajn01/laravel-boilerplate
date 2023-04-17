<?php

namespace App\Http\Livewire\Settings;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;

use Livewire\Component;

class CriticalDeviation extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public function render()
    {
        return view('livewire.settings.critical-deviation')->extends('layouts.app');
    }
}
