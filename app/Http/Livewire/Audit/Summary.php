<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;

use App\Models\Store as StoreModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;
use App\Models\Summary as SummaryModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use App\Models\ServiceSpeed as ServiceSpeedModel;
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
    public $summary_details;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
    }
    public function render()
    {
        $this->conducted_by = auth()->user()->name;
        $this->summary_details = SummaryModel::find($this->summary_id);
        if($this->summary_details->received_by){
            $this->received_by = $this->summary_details->received_by;
        }
        $this->dov = $this->summary_details->date_of_visit;
        $this->audit_forms_id = $this->summary_details->form_id;

        
        $critical_deviations = CriticalDeviationResultModel::where('form_id', $this->audit_forms_id)
            ->whereNotNull('score')
            ->get();

        $summary = DB::table('audit_results')
            ->select('category_id', 'category_name')
            ->selectRaw('COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0) AS total_base_points')
            ->selectRaw('COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0) AS total_points')
            ->selectRaw('ROUND((COALESCE(SUM(CASE WHEN is_na = 1 THEN label_base_point ELSE label_point END), 0) + COALESCE(SUM(CASE WHEN is_na = 1 THEN sub_sub_base_point ELSE sub_sub_point END), 0)) / (COALESCE(SUM(label_base_point), 0) + COALESCE(SUM(sub_sub_base_point), 0)) * 100, 2) AS percentage')
            ->where('form_id', $this->audit_forms_id)
            ->groupBy('category_id', 'category_name')
            ->get();

        $service_points = ServiceSpeedModel::selectRaw(' SUM(assembly_points + tat_points + fst_points) AS total_points, SUM(base_assembly_points + base_tat_points + base_fst_points) AS base_total')->where('form_id', $this->audit_forms_id)->first();

        foreach ($summary as $key => $value) {

            if($value->category_name == 'Service'){
                $value->total_base_points += $service_points->base_total;
                $value->total_points += $service_points->total_points;
                $value->percentage = round(($value->total_points * 100 / $value->total_base_points), 0);
            }
            $critical_deviation = $critical_deviations->where('category_id', $value->category_id)->sum('score');
            $value->percentage -= $critical_deviation ? $critical_deviation : 0;
            $value->percentage = round($value->percentage, 2);
        }
        $store = StoreModel::find($this->store_id);
        $this->store = $store;
        // dd($summary);

        return view('livewire.audit.summary', ['summary' => $summary, 'critical_deviation' => $critical_deviations])->extends('layouts.app');
    }

    public function mount($store_id = null, $result_id = null)
    {
        $this->store_id = $store_id;
        $this->summary_id = $result_id;
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
                'strength' => 'required',
                'improvement' => 'required'
            ]
        );
        SummaryModel::where('form_id', $this->audit_forms_id)
            ->update([
                'conducted_by' => $this->conducted_by,
                'received_by' => $this->received_by,
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
        redirect()->route('audit.details', ['store_id' => $this->store_id]);
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
