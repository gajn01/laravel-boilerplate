<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Store;
use App\Models\User;
use App\Models\AuditDate;
use App\Models\AuditForm;
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
    public $search;
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
        if (!Gate::allows('allow-view', 'module-audit')) {
            return redirect()->route('dashboard');
        }
        $this->date_filter = $this->date_today;
    }
    public function render()
    {
        $user = User::where('user_type', '!=', '0')->get();
        $store_list = Store::all();
         #region Schedule query
         $schedule = AuditForm::where(function ($q) {
            $q->whereHas('stores', function ($q) {
                $search = '%' . $this->search . '%';
                $q->where('stores.name', 'like', '%' . $search . '%');
                $q->orWhere('stores.code', 'like', '%' . $search . '%');
                $q->orWhere('stores.area', 'like', '%' . $search . '%');
            });
        })->when(Auth::user()->user_type != 0 ,fn($con)=>
            $con->whereHas('auditors', fn($q)=>
                $q->where('auditor_list.auditor_id',Auth::user()->id))
            )->orderByRaw('audit_date ASC');
        if ($this->date_filter == 'weekly') {
            $schedule->whereBetween('audit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->date_filter == 'monthly') {
            $schedule->whereBetween('audit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($this->date_filter == $this->date_today) {
            $schedule->where('audit_date', $this->date_today);
        }
        $store_schedule = $schedule->paginate($this->limit);
        #endregion
        return view('livewire.audit.audit', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
}