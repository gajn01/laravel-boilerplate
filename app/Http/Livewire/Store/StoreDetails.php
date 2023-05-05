<?php
namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\User as UserModel;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class StoreDetails extends Component
{
    public $store_id;
    public $store;
    public $audit_date_id;
    public $audit_date;
    public $input_type;
    public $input_code;
    public $input_name;
    public $input_area;
    public $is_edit = false;
    public $limit = 10;
    public $date_filter;
    public $today;
    public function mount($store_id = null)
    {
        $this->store_id = $store_id;
        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $this->today = $time->format('Y-m-d');
        $this->date_filter = $this->today;
    }
    public function render()
    {
        $data = UserModel::all('*')
            ->where('user_level', '!=', '0');
        $startDate = null;
        $endDate = null;
        if ($this->date_filter == 'weekly') {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
        } elseif ($this->date_filter == 'monthly') {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
        }
        if ($startDate && $endDate) {
            $schedule = DB::table('audit_date')
                ->join('stores', 'audit_date.store', '=', 'stores.id')
                ->select('audit_date.*', 'stores.name as store_name')
                ->where('audit_date.store', $this->store_id)
                ->whereBetween('audit_date.audit_date', [$startDate, $endDate])
                ->orderBy('audit_date', 'asc')
                ->paginate($this->limit);
        } else {
            $schedule = DB::table('audit_date')
                ->join('stores', 'audit_date.store', '=', 'stores.id')
                ->select('audit_date.*', 'stores.name as store_name')
                ->where('audit_date.store', $this->store_id)
                ->where('audit_date.audit_date', $this->date_filter)
                ->orderBy('audit_date', 'asc')
                ->paginate($this->limit);
        }
        $this->store = StoreModel::find($this->store_id);
        return view('livewire.store.store-details', ['user_list' => $data, 'schedule_list' => $schedule])->extends('layouts.app');
    }
    public function onUpdate($boolean)
    {
        $this->input_type = $this->store->type;
        $this->input_code = $this->store->code;
        $this->input_name = $this->store->name;
        $this->input_area = $this->store->area;
        $this->is_edit = $boolean;
    }
    public function onSaveStore()
    {
        $this->validate([
            'input_type' => 'required',
            'input_code' => 'required',
            'input_name' => 'required',
            'input_area' => 'required',
        ]);
        StoreModel::updateOrCreate(
            ['id' => $this->store_id ?? null],
            [
                'type' => strip_tags($this->input_type),
                'code' => strip_tags($this->input_code),
                'name' => strip_tags($this->input_name),
                'area' => strip_tags($this->input_area),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Store saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#assign_modal');
        $this->onUpdate(false);
        $this->is_edit = false;
    }
    public function onDelete($id)
    {
        $schedule = AuditDateModel::find($id);
        $schedule->delete();
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
