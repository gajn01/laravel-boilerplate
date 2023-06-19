<?php

namespace App\Http\Livewire\Audit;

use App\Models\auditor_list;
use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\User as UserModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\auditor_list as AuditorListModel;
use App\Helpers\CustomHelper;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;


class Audit extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $searchTerm;
    public $limit = 10;
    private $timezone;
    private $time;
    public $date_today;
    public $date_filter;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
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

        $auditorsQuery = AuditDateModel::join('auditor_list', 'auditor_list.audit_date_id', '=', 'audit_date.id')
            ->join('stores', 'audit_date.store_id', '=', 'stores.id')
            ->select('auditor_list.audit_date_id', 'stores.*', 'audit_date.wave', 'audit_date.audit_date','audit_date.is_complete')
            ->where(function ($query) use ($searchTerm) {
                $query->where('stores.name', 'like', $searchTerm)
                    ->orWhere('stores.code', 'like', $searchTerm)
                    ->orWhere('stores.area', 'like', '%' . $searchTerm . '%');
            })
            ->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC');

        if (Auth::user()->user_level != 0) {
            $auditorsQuery->where('auditor_list.auditor_id', Auth::user()->id);
        }
        if ($this->date_filter == 'weekly') {
            $auditorsQuery->whereBetween('audit_date.audit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->date_filter == 'monthly') {
            $auditorsQuery->whereBetween('audit_date.audit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($this->date_filter == $this->date_today) {
            $auditorsQuery->where('audit_date.audit_date', $this->date_today);
        }
        $store_schedule = $auditorsQuery
            ->paginate($this->limit);
        // dd($store_schedule);
        return view('livewire.audit.audit', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
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
