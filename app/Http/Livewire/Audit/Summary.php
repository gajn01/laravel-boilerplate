<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\SubCategoryLabel as SubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;
use App\Models\Summary as SummaryModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\AuditForm as AuditFormModel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;


use DateTime;
use DateTimeZone;

class Summary extends Component
{
    protected $listeners = ['start-alert-sent' => 'onComplete'];
    public $store;
    public $store_id;
    public $summary_id;
    public $result_id;
    /* Audit Category */
    public $category_list;
    public $audit_status;
    public $audit_forms_id;
    public $with;
    public $conducted_by;
    public $received_by;
    public $dov;
    public $toa;
    public $strength;
    public $improvement;
    public $wave;
    public $time_of_audit;
    private $timezone;
    private $time;
    private $date_today;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
    }
    public function render()
    {
   /*      $summary = DB::table('audit_results')
            ->select('category_id', 'category_name')
            ->selectRaw('COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0) AS total_base_points')
            ->selectRaw('COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) +COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0) AS total_points')
            ->selectRaw('ROUND((COALESCE(SUM(label_point), 0) + COALESCE(SUM(sub_sub_point), 0)) / (COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0)) * 100, 2) AS percentage')
            ->where('form_id', $this->result_id)
            ->groupBy('category_id', 'category_name')
            ->get();
             */

            $summary = DB::table('audit_results')
            ->select('category_id', 'category_name')
            ->selectRaw('COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0) AS total_base_points')
            ->selectRaw('COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0) AS total_points')
            ->selectRaw('ROUND((COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0)) / (COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0)) * 100, 2) AS percentage')
            ->where('form_id', $this->result_id)
            ->groupBy('category_id', 'category_name')
            ->get();


        $store = StoreModel::find($this->store_id);
        $this->store = $store;
        return view('livewire.audit.summary', ['summary' => $summary])->extends('layouts.app');
    }

    public function mount($store_id = null, $summary_id = null, $result_id = null)
    {
        $this->store_id = $store_id;
        $this->summary_id = $summary_id;
        $this->result_id = $result_id;
    }
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        $message = 'Are you sure you want to complete this audit?';
        $this->emit('onStartAlert', $message);
    }
    public function onComplete()
    {
        $this->validate(
            [
                'conducted_by' => '',
                'received_by' => 'required',
                'dov' => '',
                'strength' => 'required',
                'improvement' => 'required',
                'wave' => 'required',
            ]
        );
        SummaryModel::where('form_id', $this->result_id)
            ->update([
                'conducted_by' => $this->conducted_by,
                'received_by' => $this->received_by,
                'date_of_visit' => $this->dov,
                'time_of_audit' => $this->time_of_audit,
                'strength' => $this->strength,
                'improvement' => $this->improvement,
            ]);
        AuditDateModel::where('store_id', $this->store_id)
            ->where('audit_date', $this->date_today)
            ->update([
                'is_complete' => 2,
            ]);
        StoreModel::where('id', $this->store_id)
            ->update(['audit_status' => 0]);
        $this->reset();
        $this->onAlert(false, 'Success', 'Audit record saved successfully!', 'success');
        return redirect()->route('audit.details', ['store_id' => $this->store_id]);
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
