<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class PeopleForm extends Component
{
    public $data=[];
    public function mount($data = null)
    {
        $this->data = $data;
    }
    public function render()
    {
        return view('livewire.component.people-form');
    }
}
