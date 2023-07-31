<?php

namespace App\Http\Livewire\Store;

use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Helpers\CustomHelper;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Response;
use App\Helpers\ActivityLogHelper;

class Store extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $store_id,$name,$code,$type,$area,$representative;
    public $searchTerm;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    protected  ActivityLogHelper $activity;
    public function __construct()
    {
        $this->activity = new ActivityLogHelper;
    }
    public function mount() {
        if (!Gate::allows('allow-view', 'module-store-management')) {
            return redirect()->route('dashboard');
        }
    }
    public function render()
    {
        $store_list = $this->getStoreList();
        return view('livewire.store.store', ['store_list' => $store_list])->extends('layouts.app');
    }
    private function getStoreList()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $store_list = StoreModel::where('name', 'like', $searchTerm)
            ->orWhere('code', 'like', $searchTerm)
            ->orWhere('area', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('code', 'ASC')
            ->paginate($this->limit);
        return $store_list;
    }
    public function exportCSV()
    {
        $store_list = $this->getStoreList();
        $csvData = [];
        $csvData[] = ['Code', 'Name', 'Type', 'Area']; 
        foreach ($store_list as $store) {
            $csvData[] = [
                $store['code'],
                $store['name'],
                $store['type'] == 1 ? 'Cafe' : 'Kiosk',
                $store['area'],
            ];
        }
        $fileName = 'store_data_' . date('m-d-Y') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];
    
        return Response::stream(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, 200, $headers);
    }
    public function showModal($store_id = null)
    {
        $store = StoreModel::find($store_id);
        $this->name = optional($store)->name;
        $this->code = optional($store)->code;
        $this->type = optional($store)->type;
        $this->area = optional($store)->area;
        $this->resetValidation();
        $this->store_id = $store_id;
        $this->modalTitle = $this->store_id ? 'Edit Store' : 'Add Store';
        $this->modalButtonText = $this->store_id ? 'Update' : 'Add';
    }
    public function onSave()
    {
        $access = 'allow-create';
        if($this->store_id){
            $access = 'allow-edit';
        }
        if (!Gate::allows($access, 'module-store-management')) {
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->validate(
            [
                'name' => 'required|max:255',
                'code' => 'required',
                'type' => 'required|in:0,1',
                'area' => 'required|in:MFO,South,North',
            ]
        );
        $store = StoreModel::updateOrCreate(
            ['id' => $this->store_id ?? null],
            [
                'name' => strip_tags($this->name),
                'code' => strip_tags($this->code),
                'type' => strip_tags($this->type),
                'area' => strip_tags($this->area),
            ]
        );
        $action = $this->store_id ? 'update' : 'create';
        $this->onAlert(false, 'Success', 'Store saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#store_modal');
        $this->activity->onLogAction($action,'Store',$this->store_id ?? null);
        $this->resetValidation();
    }
    public function onDelete($store_id)
    {
        if(!Gate::allows('allow-delete','module-store-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $store = StoreModel::find($store_id);
        $store->delete();
        $this->activity->onLogAction('delete','Store',$store_id ?? null);

    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->resetValidation();
    }

 
}
