<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\User as UserModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\auditor_list as AuditorListModel;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;


class Schedule extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $searchTerm;
    public $limit = 10;
    public $audit_date_id;
    public $store_id;
    public $auditor_id;
    public $auditor_list = [];
    public $audit_date;
    public $wave;
    public $modalTitle = "Add";
    public $modalButtonText;
    public $date_filter;
    public $today;
    public function mount()
    {
        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $this->today = $time->format('Y-m-d');
        $this->date_filter = 'all';
    }
    public function render()
    {
        $user = UserModel::all('*')
            ->where('user_level', '!=', '0');
        $searchTerm = '%' . $this->searchTerm . '%';
        $store_list = StoreModel::all();
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
            $store_schedule = StoreModel::select('stores.*', 'stores.id as store_id', 'audit_date.id as audit_id', 'audit_date.audit_date', 'audit_date.wave')
                ->join('audit_date', 'stores.id', '=', 'audit_date.store_id')
                ->where('stores.name', 'like', $searchTerm)
                ->where('stores.code', 'like', $searchTerm)
                ->where('stores.area', 'like', '%' . $searchTerm . '%')
                ->whereBetween('audit_date.audit_date', [$startDate, $endDate])
                ->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC')
                ->paginate($this->limit);
        } else if ($this->date_filter == 'all') {
            $store_schedule = StoreModel::select('stores.*', 'stores.id as store_id', 'audit_date.id as audit_id', 'audit_date.audit_date', 'audit_date.wave')
                ->join('audit_date', 'stores.id', '=', 'audit_date.store_id')
                ->where('stores.name', 'like', $searchTerm)
                ->where('stores.code', 'like', $searchTerm)
                ->where('stores.area', 'like', '%' . $searchTerm . '%')
                ->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC')
                ->paginate($this->limit);
        } else {
            $store_schedule = StoreModel::select('stores.*', 'stores.id as store_id', 'audit_date.id as audit_id', 'audit_date.audit_date', 'audit_date.wave')
                ->join('audit_date', 'stores.id', '=', 'audit_date.store_id')
                ->where('stores.name', 'like', $searchTerm)
                ->where('stores.code', 'like', $searchTerm)
                ->where('stores.area', 'like', '%' . $searchTerm . '%')
                ->where('audit_date.audit_date', $this->date_filter)
                ->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC')
                ->paginate($this->limit);
        }
        return view('livewire.store.schedule', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
    }
    public function addAuditor()
    {
        if ($this->auditor_id) {
            $isAdded = collect($this->auditor_list)->contains('auditor_id', $this->auditor_id);
            if (!$isAdded) {
                $user = UserModel::find($this->auditor_id);
                $add = [
                    'audit_date_id' => '',
                    'auditor_id' => $this->auditor_id,
                    'auditor_name' => $user->name
                ];
                $auditorListArray = $this->auditor_list->toArray();
                array_push($auditorListArray, $add);
                $this->auditor_list = collect($auditorListArray);
            }
        }
    }
    public function removeAuditor($index)
    {
        unset($this->auditor_list[$index]);
    }
    public function saveSchedule()
    {
        $this->validate([
            'store_id' => 'required',
            'audit_date' => 'required',
            'wave' => 'required',
        ]);
        $auditDateData = [
            'store_id' => strip_tags($this->store_id),
            'audit_date' => strip_tags($this->audit_date),
            'wave' => strip_tags($this->wave),
        ];
        $auditDate = AuditDateModel::updateOrCreate(['id' => $this->audit_date_id], $auditDateData);
        $this->onAlert(false, 'Success', 'Schedule saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#store_schedule_modal');
        if (empty($this->audit_date_id)) {
            $auditorListData = collect($this->auditor_list)->map(function ($value) use ($auditDate) {
                $value['audit_date_id'] = $auditDate->id;
                return $value;
            })->toArray();
            AuditorListModel::insert($auditorListData);
            $this->auditor_list = [];
        }
    }
    public function onDelete($id)
    {
        $schedule = AuditDateModel::find($id);
        $schedule->delete();
    }
    public function showModal($id = null)
    {
        $this->audit_date_id = $id;
        $audit = AuditDateModel::find($id);
        $this->auditor_list = AuditorListModel::select('*')
            ->where('audit_date_id', $id)
            ->get();
        $this->audit_date = optional($audit)->audit_date;
        $this->store_id = optional($audit)->store_id;
        $this->audit_date = optional($audit)->audit_date;
        $this->wave = optional($audit)->wave;
        $this->resetValidation();
        $this->modalTitle = $this->audit_date_id ? 'Update' : 'Add';
        $this->modalButtonText = $this->audit_date_id ? 'Update' : 'Add';
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
