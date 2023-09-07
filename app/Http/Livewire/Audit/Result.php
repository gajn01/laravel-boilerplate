<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
/* models  */
use App\Models\Store;
use App\Models\AuditForm;

use DateTime;
use DateTimeZone;

class Result extends Component
{
    public $active_index = 0;
    public  $form;
    public $auditForm;
    public Store $store;
   
    public function mount($form_id = null)
    {
        $this->auditForm = AuditForm::find($form_id);
        $this->store = Store::find($this->auditForm->store_id);
        if($this->auditForm->audit_result){
            $this->form = json_decode($this->auditForm->audit_result, true);
            $this->onCaculatePoints();
        }else{
            redirect()->route('audit.forms', ['id' => $this->auditForm->id]);  
        }
    }
    public function render()
    {
        return view('livewire.audit.result')->extends('layouts.app');
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
    public function setActive($index)
    {
        $this->active_index = $index;
    }

}