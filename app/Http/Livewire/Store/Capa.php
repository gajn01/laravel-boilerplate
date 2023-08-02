<?php

namespace App\Http\Livewire\Store;
use Livewire\WithFileUploads;
use Livewire\Component;
use League\Csv\Reader;
use Illuminate\Http\Request;
use App\Models\Store;

class Capa extends Component
{
    use WithFileUploads;
    public $file;
    public function render()
    {
        return view('livewire.store.capa')->extends('layouts.app');
    }
    public function onImportFile(Request $request)
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);
    
        $csv = Reader::createFromPath($this->file->path(), 'r');
        $csv->setHeaderOffset(0);
        $headers = $csv->getHeader();
        $rows = $csv->getRecords();

        $dataToInsert = [];
        foreach ($rows as $row) {
            $dataToInsert[] = array_combine($headers, $row); // Add each row as an associative array to the data array
        }
        Store::insert($dataToInsert);
        /* if (!empty($dataToInsert)) {
            $existingIds = Store::pluck('id')->toArray();
            $dataToInsert = array_filter($dataToInsert, function ($item) use ($existingIds) {
                return !in_array($item['id'], $existingIds);
            });
        } */
    }
}
