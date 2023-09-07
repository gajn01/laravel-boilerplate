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
    public $form;
    public $store;
    public  $auditForm;
    protected function rules()
    {
        return [
            'auditForm.received_by' => 'required',
            'auditForm.strength' => 'nullable',
            'auditForm.improvement' => 'nullable',
        ];
    }
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
    }
  
    public function render()
    {
        return view('livewire.audit.summary')->extends('layouts.app');
    }
    public function mount($form_id = null)
    {
        $this->auditForm = AuditForm::find($form_id);
        $this->form = json_decode($this->auditForm->audit_result, true);
        $this->store = Store::find($this->auditForm->store_id);
        $this->onCaculatePoints();
    }
    public function onCaculatePoints()
    {
        foreach ($this->form as $categoryIndex => &$category) {
            $category['total-base'] = 0;
            $category['total-points'] = 0;
            $category['total-percent'] = 0; // Initialize total-percent variable
            foreach ($category['sub-category'] as $subCategoryIndex => &$subCategory) {
                $subCategory['total-base'] = 0;
                $subCategory['total-points'] = 0;
                foreach ($subCategory['deviation'] as $deviationIndex => &$deviation) {
                    if (isset($deviation['deviation'])) {
                        foreach ($deviation['deviation'] as $key => $subCategoryDeviation) {
                            if (isset($subCategoryDeviation['is-na']) && $subCategoryDeviation['is-na'] == 1) {
                                $subCategory['total-base'] += $subCategoryDeviation['base'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['points'] ?? 0;
                            } else {
                                $subCategory['total-base'] += $subCategoryDeviation['base_assembly_point'] ?? 0;
                                $subCategory['total-base'] += $subCategoryDeviation['base_tat_point'] ?? 0;
                                $subCategory['total-base'] += $subCategoryDeviation['base_fst_point'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['assembly_point'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['tat_point'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['fst_point'] ?? 0;

                                if (isset($subCategoryDeviation['server_name'])) {
                                    $subCategory['total-base'] += $subCategoryDeviation['base_att_point'] ?? 0;
                                    $subCategory['total-points'] += $subCategoryDeviation['att_point'] ?? 0;
                                } 
                            }
                        }
                    } else {
                        if (isset($deviation['is-na']) && $deviation['is-na'] == 1) {
                            $subCategory['total-base'] += $deviation['base'] ?? 0;
                            $subCategory['total-points'] += $deviation['points'] ?? 0;
                        }
                    }
                }
                $category['total-base'] += $subCategory['total-base'];
                $category['total-points'] += $subCategory['total-points'];
                
                if ($category['category'] == "Food") {
                    if ($subCategory['total-base'] != 0) {
                        $category['total-percent'] += round(($subCategory['total-points'] / $subCategory['total-base']) * $subCategory['percent'], 0);
                    } else {
                        $category['total-percent'] = 0;
                    }
                }
            }
            if($category['category'] != "Food"){
                if ($category['total-base'] != 0) {
                    $category['total-percent'] = round(($category['total-points'] / $category['total-base']) * $category['percent'], 0);
                 
                } else {
                    $subCategory['total-percent'] = 0;
                }
            }
            if (isset($category['critical-deviation'])) {
                foreach ($category['critical-deviation'] as $key => $critical_deviation) {
                    $category['total-percent'] -= (int)$critical_deviation['score'];
                }
            }
        }
    }  
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        $message = 'Are you sure you want to complete this audit?';
        $this->emit('onStartAlert', $message);
    }
    public function onComplete()
    {
        $this->auditForm->audit_status = 2;
        $this->auditForm->save();
        $this->reset();
        $this->onAlert(false, 'Success', 'Audit record saved successfully!', 'success');
        redirect()->route('audit.details', ['store_id' => $this->store->id]);  
        // $this->validate();
       /*  $this->summary->save();
        $this->store->audit_status = 0;
        $this->store->save();
        $this->auditForm->audit_status = 2;
        $this->auditForm->save();
        $this->reset();
        $this->onAlert(false, 'Success', 'Audit record saved successfully!', 'success');
        redirect()->route('audit.details', ['store_id' => $this->store->id]);  */
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