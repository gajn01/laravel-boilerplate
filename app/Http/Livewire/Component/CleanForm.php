<?php

namespace App\Http\Livewire\Component;

use Livewire\Component;

class CleanForm extends Component
{
    public $data=[];
    public $lcm=[];

    public function mount($data = null, $lcm = null)
    {
        $this->data = $data;
        $this->lcm = $lcm;
    }
    public function render()
    {
        return view('livewire.component.clean-form');
    }
}
