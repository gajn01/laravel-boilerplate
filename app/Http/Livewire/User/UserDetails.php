<?php
namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User as UserModel;
use App\Models\Store as StoreModel;
use App\Models\AuditDate as AuditDateModel;
use Livewire\WithPagination;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;

class UserDetails extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['alert-sent' => 'onDelete'];
    public $account_id;
    public $employee_id;
    public $store;
    public $audit_date_id;
    public $audit_date;
    public $name;
    public $input_employee_id;
    public $input_name;
    public $input_email;
    public $input_status;
    public $email;
    public $status;
    public $is_edit = false;
    public $modalTitle;
    public $modalButtonText;
    public $limit = 10;
    public $date_filter;
    public $today;
    public function render()
    {
        $data = StoreModel::all('*');
        $user = UserModel::where('employee_id', $this->employee_id)->first();
        $this->account_id = optional($user)->id;
        $this->name = optional($user)->name;
        $this->email = optional($user)->email;
        $this->status = optional($user)->status;
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
                ->whereBetween('audit_date.audit_date', [$startDate, $endDate])
                ->orderBy('audit_date', 'asc')
                ->paginate($this->limit);
        } else {
            $schedule = DB::table('audit_date')
                ->join('stores', 'audit_date.store', '=', 'stores.id')
                ->select('audit_date.*', 'stores.name as store_name')
                ->where('audit_date.audit_date', $this->date_filter)
                ->orderBy('audit_date', 'asc')
                ->paginate($this->limit);
        }
        return view('livewire.user.user-details', ['store_list' => $data, 'schedule_list' => $schedule])->extends('layouts.app');
    }
    public function mount($employee_id = null)
    {
        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $this->today = $time->format('Y-m-d');
        $this->date_filter = $this->today;
        $this->employee_id = $employee_id;
    }
    public function onUpdate($boolean)
    {
        $this->input_employee_id = $this->employee_id;
        $this->input_name = $this->name;
        $this->input_email = $this->email;
        $this->input_status = $this->status;
        $this->is_edit = $boolean;
    }
    public function showModal($id = null)
    {
        $this->audit_date_id = $id;
        $audit = AuditDateModel::find($id);
        $this->store = optional($audit)->store;
        $this->audit_date = optional($audit)->audit_date;
        $this->resetValidation();
        $this->modalTitle = $this->audit_date_id ? 'Edit Schedule' : 'Add Schedule';
        $this->modalButtonText = $this->audit_date_id ? 'Update' : 'Add';
    }
    public function onSaveAccount()
    {
        $this->validate(
            [
                'name' => 'required|max:255',
                'email' => 'required|email',
            ]
        );
        UserModel::updateOrCreate(
            ['id' => $this->account_id ?? null],
            [
                'name' => strip_tags($this->input_name),
                'email' => strip_tags($this->input_email),
                'status' => strip_tags($this->input_status),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Account saved successfully!', 'success');
        $this->onUpdate(false);
    }
    public function onAssign()
    {
        $this->validate(
            [
                'store' => 'required',
                'audit_date' => 'required',
            ]
        );
        AuditDateModel::updateOrCreate(
            ['id' => $this->audit_date_id ?? null],
            [
                'auditor' => strip_tags($this->account_id),
                'store' => strip_tags($this->store),
                'audit_date' => strip_tags($this->audit_date),
            ]
        );
        $this->resetValidation();
        $this->onAlert(false, 'Success', 'Schedule saved successfully!', 'success');
        CustomHelper::onRemoveModal($this, '#assign_modal');
        $this->onUpdate(false);
    }
    public function onDelete($id)
    {
        $schedule = AuditDateModel::find($id);
        $schedule->delete();
    }
    public function onTogglePassword()
    {
        /*   $this->is_toggle = !$this->is_toggle; */
        $this->emit('toggleEye');
    }
    public function test()
    {
        dd($this->date_filter);
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
