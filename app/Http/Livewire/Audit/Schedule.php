<?php
namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\AuditDate as AuditDateModel;
use App\Models\AuditorList as AuditorListModel;


use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Helpers\ActivityLogHelper;

use App\Models\Store;

use App\Models\AuditForm;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;
class Schedule extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];

    private $timezone, $time;
    public $date_today;
    public $search;
    public $limit = 10;
    public $auditor_id;
    public $auditor_list = [];
    public $new_auditor_list = [];
    public $wave = 1;
    public $modalTitle = "Add";
    public $modalButtonText;
    public $year,$date_filter;
    protected  ActivityLogHelper $activity;
    public AuditForm $auditForm;
    protected function rules()
    {
        return [
            'auditForm.store_id' => 'string|max:255',
            'auditForm.audit_date' => 'required|date',
            'auditForm.date_of_visit' => 'date',
            'auditForm.wave' => 'integer',
        ];
    }
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
        $user = $this->getAllUserExecptSuperUser();
        $store_list = Store::get();
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
            );
        if ($this->date_filter == 'weekly') {
            $schedule->whereBetween('audit_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($this->date_filter == 'monthly') {
            $schedule->whereBetween('audit_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
        } elseif ($this->date_filter == $this->date_today) {
            $schedule->where('audit_date', $this->date_today);
        }
        $store_schedule = $schedule->paginate($this->limit);
        #endregion
        return view('livewire.audit.schedule', ['store_list' => $store_list, 'store_sched_list' => $store_schedule, 'user_list' => $user])->extends('layouts.app');
    }
    public function getAllUserExecptSuperUser(){
        return User::where('user_type', '!=', '0')->get();
    }
    public function getSchedule(){

    }
    public function addAuditor()
    {
        if ($this->auditor_id) {
            $isAdded = collect($this->auditor_list)->contains('auditor_id', $this->auditor_id);
            $user = User::find($this->auditor_id);
            if (!$isAdded) {
                $this->auditor_list = collect($this->auditor_list); // Convert the array to a collection
                $this->auditor_list->push([
                    'audit_form_id' => '',
                    'auditor_id' => $this->auditor_id,
                    'auditor_name' => $user->name
                ]);
            }
            $isExisting = AuditorListModel::where('auditor_id', $this->auditor_id)->where('audit_form_id', $this->auditForm->id)->exists();
            if (!$isExisting) {
                $this->new_auditor_list = collect($this->new_auditor_list); // Convert the array to a collection
                $this->new_auditor_list->push([
                    'audit_form_id' => $this->auditForm->id,
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
        if($this->modalTitle != "Add"){
            $access = 'allow-edit';
        }
        if(!Gate::allows($access,'module-schedule-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->auditForm->audit_status = 0;
        $this->auditForm->date_of_visit = $this->date_today;
        $this->auditForm->time_of_audit = $this->time;
        $this->auditForm->conducted_by_id = Auth::user()->id;
        $this->auditForm->save();

        $this->onAlert(false, 'Success', 'Schedule saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#store_schedule_modal');
        
        if ($this->modalTitle == "Add") {
            $audit_form_id = $this->auditForm->id;
            $auditorListData = collect($this->auditor_list)->map(function ($value) use ($audit_form_id) {
                $value['audit_form_id'] = $audit_form_id;
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
        $this->auditor_list = [];
        $this->auditor_id = null;
        $action = $this->modalTitle != "Add" ? 'update' : 'create';
        $this->activity->onLogAction($action,'Schedule',$this->auditForm->id ?? null);
    }
    public function onDelete($id)
    {
        if(!Gate::allows('allow-delete','module-schedule-management')){
            $this->onAlert(false, 'Action Cancelled', 'Unable to perform action due to user is unauthorized!', 'warning');
            return;
        }
        $this->auditForm = new AuditForm;
        $this->auditForm = AuditForm::find($id);
        $this->auditForm->delete();
        $this->activity->onLogAction('delete','Schedule',$id ?? null);
    }
    public function showModal($id = null)
    {
        $this->auditForm = new AuditForm;
        $this->auditor_list = [];
        $this->auditor_id = null;
        if($id){
            $this->auditForm = AuditForm::find($id);
            $this->auditor_list = AuditorListModel::where('audit_form_id', $id)->get();
        }
        $this->resetValidation();
        $this->modalTitle = $id ? 'Update' : 'Add';
        $this->modalButtonText = $id ? 'Update' : 'Add';
    }
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
    public function reset(...$properties)
    {
        $this->auditForm = new AuditForm;
        $this->resetValidation();
    }
}