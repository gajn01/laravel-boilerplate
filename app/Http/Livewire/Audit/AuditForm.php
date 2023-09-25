<?php

namespace App\Http\Livewire\Audit;
use App\Helpers\CustomHelper;
use Livewire\Component;
use Illuminate\Database\QueryException;
use App\Models\AuditForm as AuditFormModel;
use App\Models\Store;
use App\Models\SanitaryModel;
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
        $this->store = Store::find($this->auditForm->store_id);
        if ($this->auditForm->audit_result) {
            $this->form = json_decode($this->auditForm->audit_result, true);
        } else {
            $saved_data = AuditTemplate::where('type', $this->store->type)->first();
            $this->form = json_decode($saved_data->template, true);
        }
        $this->onCaculatePoints();
    }
    public function render()
    {
        $this->auditForm = AuditFormModel::find($this->form_id);
        $this->store = Store::find($this->auditForm->store_id);
        if ($this->auditForm->audit_result) {
            $this->form = json_decode($this->auditForm->audit_result, true);
        } else {
            $saved_data = AuditTemplate::where('type', $this->store->type)->first();
            $this->form = json_decode($saved_data->template, true);
        }
        $this->onCaculatePoints();
        return view('livewire.audit.audit-form')->extends('layouts.app');
    }
    public function updatedForm($value, $key)
    {
        try {
            $this->onCaculatePoints();
            AuditFormModel::find($this->form_id)->update(['audit_status' => 1, 'audit_result' => $this->form]);
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
    }
    public function onSave()
    {
        try {
            session_start();
            if (isset($_SESSION['form'])) {
                AuditFormModel::find($this->form_id)->update(['audit_status' => 1, 'audit_result' => $this->form]);
            }
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
    }
    public function onCaculatePoints()
    {
        try {
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
                                    $subCategory['total-points'] += (int) $subCategoryDeviation['points'] ?? 0;
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
                if ($category['category'] != "Food") {
                    if ($category['total-base'] != 0) {
                        $category['total-percent'] = round(($category['total-points'] / $category['total-base']) * $category['percent'], 0);

                    } else {
                        $subCategory['total-percent'] = 0;
                    }
                }
                if (isset($category['critical-deviation'])) {
                    foreach ($category['critical-deviation'] as $key => $critical_deviation) {
                        $category['total-percent'] -= (int) $critical_deviation['score'];
                    }
                }
            }
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }

    }
    public function onRemoveService($category_index, $sub_category_index, $sub_sub_category_index, $sub_sub_sub_category_index)
    {
        try {
            if (isset($this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][$sub_sub_sub_category_index])) {
                array_splice(
                    $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'],
                    $sub_sub_sub_category_index,
                    1
                );
            }
            $this->onCaculatePoints();
            AuditFormModel::find($this->form_id)->update(['audit_status' => 1, 'audit_result' => $this->form]);
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
    }
    public function onAddCashier($category_index, $sub_category_index, $sub_sub_category_index)
    {
        try {
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
            $this->onCaculatePoints();
            AuditFormModel::find($this->form_id)->update(['audit_status' => 1, 'audit_result' => $this->form]);
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
    }
    public function onAddServer($category_index, $sub_category_index, $sub_sub_category_index)
    {
        try {
            $newService = [
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
            $this->onCaculatePoints();
            AuditFormModel::find($this->form_id)->update(['audit_status' => 1, 'audit_result' => $this->form]);
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
    }
    public function onInitialSave()
    {
        try {
            return $auditResults = collect($this->form)->flatMap(function ($data) {
                $result = [
                    'category' => 'Food',
                    'total-base' => 94,
                    'total-points' => 94,
                    'percent' => 100,
                    'total-percent' => 100.0
                ];
                // dd($result);
                return collect($data['sub-category'])->flatMap(function ($sub) use ($data) {
                    return collect($sub['deviation'])->map(function ($child) use ($data, $sub) {
                        $result = [
                            'category' => $data['category'],
                            'total-base' => $data['total-base'],
                            'total-points' => $data['total-points'],
                            'percent' => $data['percent'],
                            'total-percent' => 0,
                            'sub-category' => $sub['title'],
                            'sub-total-base' => $sub['total-base'],
                            'sub-total-points' => $sub['total-points'],
                            'sub-percent' => $sub['percent'],
                            'deviation' => $child['title'],
                            'is-na' => $child['is-na'] ?? 0,
                            'is-aon' => $child['is-aon'] ?? 0,
                            'base' => $child['base'] ?? 0,
                            'points' => $child['points'] ?? 0,
                            'remarks' => $child['remarks'] ?? '',
                            'critical-deviation' => $child['critical-deviation'] ?? '',
                            'deviation-dropdown' => json_encode($child['deviation-dropdown'] ?? []),
                        ];
                        return [$result];
                    });
                });
            });
        } catch (QueryException $e) {
            $this->onAlert(false, 'Error', $e->getMessage(), 'error');
        }
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