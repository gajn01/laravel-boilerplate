<?php

namespace App\Http\Livewire\Audit;

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
    public $store_id = 1;
    public $auditor_id;
    public $auditor_list = [];
    public $audit_date;
    public $wave = 1;
    public $modalTitle = "Add";
    public $modalButtonText;
    public $today;
    private $timezone;
    private $time;
    public $date_today;
    public $year;
    public $date_filter;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->year = $this->time->format('Y');

    }
    public function mount()
    {
        $this->date_filter = $this->date_today;
    }
    public function render()
    {

        $user = UserModel::all('*')
            ->where('user_level', '!=', '0');
        $searchTerm = '%' . $this->searchTerm . '%';
        $store_list = StoreModel::all();
        $auditorsQuery = StoreModel::select('stores.*', 'stores.id as store_id', 'audit_date.id as audit_id', 'audit_date.audit_date', 'audit_date.wave')
            ->join('audit_date', 'stores.id', '=', 'audit_date.store_id')
            ->where('stores.name', 'like', $searchTerm)
            ->where('stores.code', 'like', $searchTerm)
            ->where('stores.area', 'like', '%' . $searchTerm . '%')
            ->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC');

        if ($this->date_filter == 'weekly') {
            $auditorsQuery->whereBetween('audit_date.audit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->date_filter == 'monthly') {
            $auditorsQuery->whereBetween('audit_date.audit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($this->date_filter == $this->date_today) {
            $auditorsQuery->where('audit_date.audit_date', $this->date_today);
        }
        $store_schedule = $auditorsQuery
            ->paginate($this->limit);
        return view('livewire.audit.schedule', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
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

        $check_schedule = AuditDateModel::where('store_id', $this->store_id)
            ->where('wave', $this->wave)
            ->where('audit_date', 'LIKE', $this->year . '-%')
            ->first();
        if ($check_schedule) {
            $this->onAlert(false, 'Warning', 'The store has already been scheduled for this year for the same wave.', 'warning');
        } else {
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
