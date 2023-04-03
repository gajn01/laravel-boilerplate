<?php

namespace App\Http\Livewire\Settings;
use App\Models\SanitaryModel;

use Livewire\Component;

class Sanitary extends Component
{
    public $sanitary_list = [];
    public $title;
    public $code;
    public $showModal = true;

    public function render()
    {
        return view('livewire.settings.sanitary')->extends('layouts.app');
    }
    public function mount()
    {
        $this->sanitary_list = SanitaryModel::all()->map(function ($sanitary) {
            return [
                'id' => $sanitary->id,
                'title' => $sanitary->title,
                'code' => $sanitary->code,
            ];
        })->toArray();
    }



    public function onSave(){
        $this->validate([
            'title' => 'required',
            'code' => 'required',
        ], [
            'title.required' => 'The title field is required.',
            'code.required' => 'The code field is required.',
        ]);
        $sanitary = new SanitaryModel();
        $sanitary->title = $this->title;
        $sanitary->code = $this->code;
        $sanitary->save();
        $this->sanitary_list = SanitaryModel::all()->map(function ($sanitary) {
            return [
                'id' => $sanitary->id,
                'title' => $sanitary->title,
                'code' => $sanitary->code,
            ];
        })->toArray();
        session()->flash('message', 'Sanitary item saved successfully!');
        $this->emit('saved');
        return redirect()->route('sanitary');
    }
}

