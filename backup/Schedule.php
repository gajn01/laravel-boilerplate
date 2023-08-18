<?php
namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\Store as StoreModel;
use App\Models\User as UserModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\AuditorList as AuditorListModel;
use App\Models\AuditForm as AuditFormModel;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use App\Helpers\ActivityLogHelper;


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
    public $new_auditor_list = [];
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
    protected  ActivityLogHelper $activity;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->year = $this->time->format('Y');
        $this->activity = new ActivityLogHelper;
    }
    public function mount()
    {
        if (!Gate::allows('allow-view', 'module-schedule-management')) {
            return redirect()->route('dashboard');
        }
        $this->date_filter = $this->date_today;
    }
    public function render()
    {
        $user = UserModel::where('user_type', '!=', '0')->get();
        $store_list = StoreModel::all();
        #region Schedule query
        $schedule = AuditDateModel::where(function ($q) {
            $q->whereHas('store', function ($q) {
                $searchTerm = '%' . $this->searchTerm . '%';
                $q->where('stores.name', 'like', '%' . $searchTerm . '%');
                $q->orWhere('stores.code', 'like', '%' . $searchTerm . '%');
                $q->orWhere('stores.area', 'like', '%' . $searchTerm . '%');
            });
        })->orderByRaw('ISNULL(audit_date.audit_date), audit_date.audit_date ASC');
        if (Auth::user()->user_type != 0) {
            $schedule->when(Auth::user()->user_type != 0 ,fn($con)=>
                $con->whereHas('auditors', fn($q)=>
                    $q->where('auditor_list.auditor_id',Auth::user()->id)
                )
            );
        }
        if ($this->date_filter == 'weekly') {
            $schedule->whereBetween('audit_date.audit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->date_filter == 'monthly') {
            $schedule->whereBetween('audit_date.audit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($this->date_filter == $this->date_today) {
            $schedule->where('audit_date.audit_date', $this->date_today);
        }
        $store_schedule = $schedule->paginate($this->limit);
        #endregion
        return view('livewire.audit.schedule', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
    }
    public function addAuditor()
    {
        if ($this->auditor_id) {
            $isAdded = collect($this->auditor_list)->contains('auditor_id', $this->auditor_id);
            $user = UserModel::find($this->auditor_id);
            if (!$isAdded) {
                $this->auditor_list = collect($this->auditor_list); // Convert the array to a collection
                $this->auditor_list->push([
                    'audit_date_id' => '',
                    'auditor_id' => $this->auditor_id,
                    'auditor_name' => $user->name
                ]);
            }
            $isExisting = AuditorListModel::where('auditor_id', $this->auditor_id)
                                            ->where('audit_date_id', $this->audit_date_id)
                                            ->exists();
            if (!$isExisting) {
                $this->new_auditor_list = collect($this->new_auditor_list); // Convert the array to a collection
                $this->new_auditor_list->push([
                    'audit_date_id' => $this->audit_date_id,
                    'auditor_id' => $this->auditor_id,
                    'auditor_name' => $user->name
                ]);
            }
        }
    }
    public function removeAuditor($index)
    {
        if($this->audit_date_id){
            $auditor = AuditorListModel::find($this->auditor_list[$index]->id);
            $auditor->delete();
        }
        unset($this->auditor_list[$index]);
    }
    public function saveSchedule()
    {
        $access = 'allow-create';
        if($this->audit_date_id){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-schedule-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->validate([
            'store_id' => 'required',
            'audit_date' => 'required',
            'wave' => 'required',
        ]);
        $auditDateData = [
            'store_id' => strip_tags($this->store_id),
            'audit_date' => strip_tags($this->audit_date),
            'wave' => strip_tags($this->wave),
            'is_complete' => 0
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
        } else {
            if($this->new_auditor_list){
                AuditorListModel::insert($this->new_auditor_list->toArray());
                $this->new_auditor_list = [];
            }
        }
        AuditFormModel::where('audit_date_id', $this->audit_date_id)
            ->update(['date_of_visit' => $this->audit_date]);
        $action = $this->audit_date_id ? 'update' : 'create';
        $this->activity->onLogAction($action,'Schedule',$this->audit_date_id ?? null);

    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-schedule-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $schedule = AuditDateModel::find($id);
        $schedule->delete();
        $this->activity->onLogAction('delete','Schedule',$id ?? null);

    }
    public function showModal($id = null)
    {
        $this->audit_date_id = $id;
        $audit = AuditDateModel::find($id);
        $this->auditor_list = AuditorListModel::where('audit_date_id', $id)
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