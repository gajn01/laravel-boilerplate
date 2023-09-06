<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use App\Models\AuditForm as AuditFormModel;
use App\Models\Store;
use App\Models\SanitaryModel;
use App\Models\StoreRecord;
use App\Models\AuditTemplate;

class AuditForm extends Component
{
    public $auditForm;
    public $store;
    public $active_index = 0;
    public $sanitary_list;
    public $form;
    public $form_id;
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    public function mount($id = null)
    {
    //    dd( json_encode($this->form));
        $this->sanitary_list = SanitaryModel::get();
        $this->form_id = $id;   
        $this->auditForm = AuditFormModel::find($id);
        $this->store = Store::find($this->auditForm->store_id)->first();
        if($this->auditForm->audit_result){
            $this->form = json_decode($this->auditForm->audit_result, true);
        }else{
            $saved_data = AuditTemplate::where('type', $this->store->type)->first();
            $this->form = json_decode($saved_data->template, true);
        }
        $this->onCaculatePoints();
    }
    public function render()
    {
       $this->onCaculatePoints();
        return view('livewire.audit.audit-form')->extends('layouts.app');
    }
    public function updatedForm($value, $key)
    {
        AuditFormModel::find($this->form_id)->update(['audit_status' => 1,'audit_result' => $this->form]);

    }
    public function onCaculatePoints()
    {
        foreach ($this->form as $categoryIndex => &$category) {
            $category['total-base'] = 0;
            $category['total-points'] = 0;
            foreach ($category['sub-category'] as $subCategoryIndex => &$subCategory) {
                $subCategory['total-base'] = 0;
                $subCategory['total-points'] = 0;
                foreach ($subCategory['deviation'] as $deviationIndex => &$deviation) {
                    if(isset($deviation['deviation'])){
                        foreach ($deviation['deviation'] as $key => $subCategoryDeviation) {
                            if (isset($subCategoryDeviation['is-na']) && $subCategoryDeviation['is-na'] == 1) {
                                 $subCategory['total-base'] += $subCategoryDeviation['base'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['points'] ?? 0;
                              
                            } else{
                                if(isset($subCategoryDeviation['cashier_name'])){
                                     $subCategory['total-base'] += $subCategoryDeviation['base_assembly_point'] ?? 0;
                                     $subCategory['total-base'] += $subCategoryDeviation['base_tat_point'] ?? 0;
                                     $subCategory['total-base'] += $subCategoryDeviation['base_fst_point'] ?? 0;
                                     $subCategory['total-points'] += $subCategoryDeviation['assembly_point'] ?? 0;
                                     $subCategory['total-points'] += $subCategoryDeviation['tat_point'] ?? 0;
                                     $subCategory['total-points'] += $subCategoryDeviation['fst_point'] ?? 0;
                                }else{
                                    $subCategory['total-base'] += $subCategoryDeviation['base_assembly_point'] ?? 0;
                                    $subCategory['total-base'] += $subCategoryDeviation['base_tat_point'] ?? 0;
                                    $subCategory['total-base'] += $subCategoryDeviation['base_fst_point'] ?? 0;
                                    $subCategory['total-base'] += $subCategoryDeviation['base_att_point'] ?? 0;
                                    $subCategory['total-points'] += $subCategoryDeviation['assembly_point'] ?? 0;
                                    $subCategory['total-points'] += $subCategoryDeviation['tat_point'] ?? 0;
                                    $subCategory['total-points'] += $subCategoryDeviation['fst_point'] ?? 0;
                                    $subCategory['total-points'] += $subCategoryDeviation['att_point'] ?? 0;
                                }
                            }
                        }
                    }else{
                        if (isset($deviation['is-na']) && $deviation['is-na'] == 1) {
                            $subCategory['total-base'] += $deviation['base'] ?? 0;
                            $subCategory['total-points'] += $deviation['points'] ?? 0;
                        } 
                    }
                }
                $category['total-base'] += $subCategory['total-base'] ?? 0;
                $category['total-points'] += $subCategory['total-points'] ?? 0;
            }
        }
    }
    public function onRemoveService($category_index, $sub_category_index, $sub_sub_category_index, $sub_sub_sub_category_index)
    {
        if (isset($this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][$sub_sub_sub_category_index])) {
            array_splice(
                $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'],
                $sub_sub_sub_category_index,
                1
            );
        }
    }
    public function onAddCashier($category_index, $sub_category_index, $sub_sub_category_index)
    {
        $newService = [
            'cashier_name' => '',
            'product_ordered' => '',
            'ot_time' => '',
            'ot' => '',
            'assembly' => '',
            'base_assembly_point' => 1,
            'assembly_point' => 1,
            'serving_time' => '00:05',
            'tat_time' => '',
            'base_tat_point' => 1,
            'tat_point' => 1,
            'fst_time' => '',
            'base_fst_point' => 3,
            'fst_point' => 3,
            'remarks' => '',
        ];
        $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][] = $newService;
        // dd($this->form);
    }
    public function onAddServer($category_index, $sub_category_index, $sub_sub_category_index)
    {
        $newService =  [
            'server_name' => '',
            'product_ordered' => '',
            'ot_time' => '',
            'ot' => '',
            'assembly' => '',
            'base_assembly_point' => 1,
            'assembly_point' => 1,
            'serving_time' => '00:05',
            'tat_time' => '',
            'base_tat_point' => 1,
            'tat_point' => 1,
            'fst_time' => '',
            'base_fst_point' => 5,
            'fst_point' => 5,
            'att_time' => '',
            'base_att_point' => 1,
            'att_point' => 1,
            'remarks' => '',
        ];
        $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][] = $newService;
        // dd($this->form);
    }
}