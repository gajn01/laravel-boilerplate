<?php

namespace App\Http\Livewire\Settings;
use App\Models\SanitaryModel;

use Livewire\Component;

class Sanitary extends Component
{
    public $sanitary_list = [];
    public $sanitary_id;
    public $title;
    public $code;
    public $showModal = true;

    public function render()
    {
        return view('livewire.settings.sanitary')->extends('layouts.app');
    }
    public function mount()
    {
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
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
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        session()->flash('message', 'Sanitary item saved successfully!');
        $this->emit('saved');
        $this->reset();
        return redirect()->route('sanitary');
    }
    public function getSanitaryId($sanitary_id)
    {
        $sanitary = SanitaryModel::find($sanitary_id);
        $this->title = $sanitary->title;
        $this->code = $sanitary->code;
        $this->sanitary_id = $sanitary_id;
    }

    public function onDeleteSanitary($sanitary_id){
        $sanitary = SanitaryModel::find($sanitary_id);
        $sanitary->delete();
        $this->sanitary_list = SanitaryModel::all(['id', 'title', 'code'])->toArray();
        session()->flash('message', 'Sanitary item deleted successfully!');
        $this->emit('saved');
        return redirect()->route('sanitary');

    }


    public function reset(...$properties){

        $this->title = '';
        $this->code = '';
        $this->sanitary_id = '';
        $this->resetValidation();
    }
}
