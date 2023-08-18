<?php
namespace App\Http\Livewire\Audit;

use Livewire\Component;

use App\Models\Store;
use App\Models\Summary as SummaryModel;
use App\Models\CriticalDeviationResult;

use App\Models\AuditForm;
use App\Models\AuditDate;
use App\Models\AuditFormResult;
use App\Models\Category;
use App\Models\ServiceSpeed;

use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class Summary extends Component
{
    protected $listeners = ['start-alert-sent' => 'onComplete'];
    private $timezone, $time, $date_today;
    public $criticalDeviationResultList;
    public $auditResult;
    public Store $store;
    public SummaryModel $summary;
    public AuditForm $auditForm;
    public AuditDate $auditDate;
    public ServiceSpeed $serviceSpeed;

    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->onInitialize();
    }
    protected function rules()
    {
        return [
            'summary.conducted_by' => 'string|max:255',
            'summary.received_by' => 'required|string|max:255',
            'summary.strength' => 'string|max:255',
            'summary.improvement' => 'string|max:255',
            'summary.overall_score' => 'string|max:255',
            'summary.date_of_visit' => 'string|max:255',
        ];
    }
    public function onInitialize()
    {
        $this->store = new Store;
        $this->summary = new SummaryModel;
        $this->store = new Store;
        $this->auditForm = new AuditForm;
        $this->auditDate = new AuditDate;
        $this->serviceSpeed = new ServiceSpeed;
    }
    public function render()
    {
        $summaryList = $this->getTotalScore()->toArray();
        $documentAndPeopleList =  $this->getTotalScoreForDocumentAndPeople()->toArray();
        return view('livewire.audit.summary',['summaryList' =>$summaryList,'documentAndPeopleList'=>$documentAndPeopleList])->extends('layouts.app');
    }
    public function mount($form_id = null, $summary_id = null)
    {
        $this->auditForm = AuditForm::find($form_id);
        $this->store = Store::find($this->auditForm->store_id);
        $this->summary = SummaryModel::find($summary_id);
        $this->criticalDeviationResultList = CriticalDeviationResult::where('form_id', $this->auditForm->id)
            ->whereNotNull('score')
            ->get();
        $this->auditResult = AuditFormResult::where('form_id', $this->summary->form_id)->get();
    }
    public function getCategoryList()
    {
        return Category::where('type', $this->store->type)->whereNotIn('id', [6, 7]) ->orderBy('type', 'DESC') ->orderBy('order', 'ASC')->get();
    }
    public function getTotalScore()
    {
        return $this->getCategoryList()->transform(function ($category) {
            return [
                'id' => $category['id'],
                'category_name' => $category['name'],
                'percent' =>  100,
                'percentage' => $this->getSummaryScore($category['id'])
            ];
        });
    }
    public function getSummaryScore($category_id)
    {
        $total_bp = 0;
        $total_points = 0;
        $total_percentage = 0;
        $results = AuditFormResult::where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get();
        foreach ($results as $data) {
            if (!$data->label_id) {
                if ($category_id == 2) {
                    $subNameMappings = [
                        ["name" => "Ensaymada", "percent" => 20],
                        ["name" => "Cheese roll", "percent" => 20],
                        ["name" => "Espresso", "percent" => 30],
                        ["name" => "Infused Water", "percent" => 10],
                        ["name" => "Cake Display", "percent" => 20],
                    ];
                    foreach ($subNameMappings as $mapping) {
                        if ($mapping['name'] != "Cake Display") {
                            $total_bp = $data->where('form_id',$this->auditForm->id)->where('sub_name', $mapping['name'])->get()->sum('sub_sub_base_point');
                            $total_points = $data->where('form_id',$this->auditForm->id)->where('sub_name', $mapping['name'])->get()->sum('sub_sub_point');
                        } else {

                            $total_bp = $data->where('form_id',$this->auditForm->id)->where('sub_name', $mapping['name'])->get()->sum('label_base_point');
                            $total_points = $data->where('form_id',$this->auditForm->id)->where('sub_name', $mapping['name'])->get()->sum('label_point');
                        }
                        $total_percentage += ($total_bp == 0) ? 0 : round(($total_points / $total_bp) * $mapping["percent"], 0);

                    }
                    return $total_percentage - CriticalDeviationResult::where('form_id', $this->summary->form_id)->where('category_id', 2 )->whereNotNull('score')->sum('score');
                }else{
                    $total_bp += $data->sub_sub_base_point;
                    $total_points += $data->sub_sub_point;
                }
            } else {
                $total_bp += $data->label_base_point;
                $total_points += $data->label_point;
            }
        }
        $total_percentage = ($total_bp == 0) ? 0 : round(($total_points / $total_bp) * 100, 0);
        return $total_percentage - CriticalDeviationResult::where('form_id', $this->summary->form_id)->where('category_id',$category_id )->whereNotNull('score')->get()->sum('score');
    }
    public function getCategoryDocumentAndPeopleList()
    {
        return Category::where('type', $this->store->type)->whereIn('id', [6, 7])->orderBy('type', 'DESC')->orderBy('order', 'ASC')->get();
    }
    public function getTotalScoreForDocumentAndPeople()
    {
        return $this->getCategoryDocumentAndPeopleList()->transform(function ($category) {
            return [
                'id' => $category['id'],
                'category_name' => $category['name'],
                'percent' =>  $category['id'] == 6 ? 40: 60,
                'percentage' => $this->getSummaryScoreForDocumentAndPeople($category['id'])
            ];
        });
    }
    public function getSummaryScoreForDocumentAndPeople($category_id)
    {
        $total_bp = 0;
        $total_points = 0;
        $total_percentage = 0;
        $percent = ($category_id == 7) ? 60 : 40;
        $results = AuditFormResult::where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get();
        foreach ($results as $data) {
            if (!$data->label_id) {
                $total_bp = $data->where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get()->sum('sub_sub_base_point');
                $total_points = $data->where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get()->sum('sub_sub_point');
            }else{
                $total_bp = $data->where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get()->sum('label_base_point');
                $total_points = $data->where('form_id', $this->summary->form_id)->where('category_id', $category_id)->get()->sum('label_point');
            }
             $total_percentage = ($total_bp == 0) ? 0 : round(($total_points / $total_bp) * $percent, 0);
            return $total_percentage - CriticalDeviationResult::where('form_id', $this->summary->form_id)->where('category_id',$category_id )->whereNotNull('score')->get()->sum('score');
        }
    }
   
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        $message = 'Are you sure you want to complete this audit?';
        $this->emit('onStartAlert', $message);
    }
    public function onComplete()
    {
        // $this->validate();
        $this->summary->save();
        $this->store->audit_status = 0;
        $this->store->save();
        $this->auditForm->audit_status = 2;
        $this->auditForm->save();
        $this->reset();
        $this->onAlert(false, 'Success', 'Audit record saved successfully!', 'success');
        redirect()->route('audit.details', ['store_id' => $this->store->id]); 
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