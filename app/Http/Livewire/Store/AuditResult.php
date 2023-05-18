<?php

namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\AuditForm as AuditFormModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class AuditResult extends Component
{
    public $active_index = 0;
    protected $listeners = ['alert-sent' => 'onUpdateStatus', 'start-alert-sent' => 'onUpdateStatus'];
    public $store_id;
    public $store_name;
    /* Audit Category */
    public $category_list;
    public $store_type;
    public $f_major_sd = [];
    public $f_product;
    public $sanitation_defect;
    public $audit_status;
    public $audit_forms_id;
    public $actionTitle = 'Start';
    public $currentField;
    public $currentIndex;
    public $cashier_tat = [['name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'ot_point' => 1, 'tat' => null, 'tat_point' => 1, 'fst' => null, 'fst_point' => 3, 'remarks' => null]];
    public $server_cat = [['name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'ot_point' => 1, 'tat' => null, 'tat_point' => 1, 'fst' => null, 'fst_point' => 3, 'remarks' => null]];
    protected $rules = [
        'category_list.*.sub_categ.data_items.*.id' => 'required',
        'category_list.*.sub_categ.data_items.*.name' => 'required',
        'category_list.*.sub_categ.data_items.*.sub_category.*.*' => 'required',
    ];
    /*   public $message = '';
    public $uppercaseMessage = '';
    public function updated($propertyName)
    {
    if ($propertyName === 'message') {
    // Update the $uppercaseMessage property whenever the $message property changes
    $this->uppercaseMessage = strtoupper($this->message);
    }
    }
    */
    public function render()
    {
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();

        $this->audit_forms_id = AuditFormModel::where('store_id', $this->store_id)->value('id');
        // dd($audit_result);
        $store = StoreModel::find($this->store_id);
        $this->store_name = $store->name;
        $this->store_type = $store->type;
        $this->audit_status = $store->audit_status;
        $this->actionTitle = $this->audit_status ? 'Complete' : 'Start';

        $data = CategoryModel::select('id', 'name', 'type', 'critical_deviation')
            ->where('type', $this->store_type)
            ->with([
                'subCategories.subCategoryLabels' => function ($query) {
                    $query->selectRaw('id, name, is_all_nothing, bp, sub_category_id, dropdown_id');
                },
            ])
            ->get();
        foreach ($data as $category) {
            $subCategories = $category->subCategories;
            $category_id = $category->id;
            $sub_category_id = 0;
            $sub_sub_category_id = 0;
            $total_bp = 0;
            $total_base = 0;
            $total_score = 0;
            $saved_critical_score = 0;
            $sub_category = [
                'data_items' => $subCategories->map(function ($subCategory) use (&$total_bp, &$category_id, &$sub_category_id, &$sub_sub_category_id, &$total_base, &$total_score) {
                    $sub_category_id = $subCategory->id;
                    $subCategoryData = [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'base_score' => 0,
                        'total_point' => 0,
                        'total_percent' => 0,
                    ];
                    $subCategoryData['sub_category'] = ($subCategory->is_sub == 0) ? $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$category_id, &$sub_category_id, &$sub_sub_category_id, &$total_points, &$total_base, &$total_score) {
                        $sub_sub_category_id = $label->id;
                        $saved_point = 0;
                        $saved_remarks = '';
                        $saved_deviation = '';
                        if ($this->audit_status) {
                            $data = AuditFormResultModel::select('*')
                                ->where('form_id', $this->audit_forms_id)
                                ->where('category_id', $category_id)
                                ->where('sub_category_id', $sub_category_id)
                                ->where('sub_sub_category_id', $sub_sub_category_id)
                                ->first();
                            $saved_point = $data ? $data['sub_sub_point'] : null;
                            $saved_remarks = $data ? $data['sub_sub_remarks'] : null;
                            $saved_deviation = $data ? $data['sub_sub_deviation'] : null;
                        } else {
                            $saved_point = $label->bp;
                        }
                        $dropdownMenu = DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray();
                        $isAllNothing = $label->is_all_nothing;
                        $total_base += $label->bp;
                        $total_bp += $label->bp;

                        $total_points += $saved_point;
                        $total_score += $saved_point;
                        return [
                            'id' => $label->id,
                            'name' => $label->name,
                            'bp' => $label->bp,
                            'is_all_nothing' => $isAllNothing,
                            'points' => $saved_point,
                            'remarks' => $saved_remarks,
                            'tag' => '',
                            'deviation' => $saved_deviation,
                            'dropdown' => $dropdownMenu,
                        ];
                    }) : $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_points, &$total_base, &$total_score, &$category_id, &$sub_category_id, &$sub_sub_category_id, ) {
                        $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                        $subLabelData = $subLabels->map(function ($subLabel) use (&$total_bp, &$total_points, &$total_base, &$total_score, &$category_id, &$sub_category_id, &$sub_sub_category_id, ) {
                            $sub_sub_category_id = $subLabel->sub_sub_category_id;
                            $subLabel->id;
                            $saved_point = 0;
                            $saved_remarks = '';
                            $saved_deviation = '';
                            if ($this->audit_status) {
                                $data = AuditFormResultModel::select('*')
                                    ->where('form_id', $this->audit_forms_id)
                                    ->where('category_id', $category_id)
                                    ->where('sub_category_id', $sub_category_id)
                                    ->where('sub_sub_category_id', $sub_sub_category_id)
                                    ->where('label_id', $subLabel->id)
                                    ->first();
                                $saved_point = $data ? $data['label_point'] : null;
                                $saved_remarks = $data ? $data['label_remarks'] : null;
                                $saved_deviation = $data ? $data['label_deviation'] : null;
                            } else {
                                $saved_point = $subLabel->bp;
                            }
                            $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                            $isAllNothing = $subLabel->is_all_nothing;
                            $total_bp += $subLabel->bp;
                            $total_base += $subLabel->bp;

                            $total_points += $saved_point;
                            $total_score += $saved_point;
                            return [
                                'id' => $subLabel->id,
                                'name' => $subLabel->name,
                                'bp' => $subLabel->bp,
                                'is_all_nothing' => $isAllNothing,
                                'points' => $saved_point,
                                'remarks' => $saved_remarks,
                                'deviation' => $saved_deviation,
                                'dropdown' => $dropdownMenu,
                            ];
                        });
                        return [
                            'id' => $label->id,
                            'name' => $label->name,
                            'label' => $subLabelData,
                        ];
                    });
                    $subCategoryData['base_score'] = $total_bp;
                    $subCategoryData['total_base'] = $total_base;
                    $subCategoryData['total_point'] = $total_points;
                    $subCategoryData['total_score'] = $total_score;
                    $subCategoryData['total_percent'] = $total_bp != 0 ? round(($total_points * 100 / $total_bp), 0) : 0;
                    $total_bp = 0;
                    $total_points = 0;
                    return $subCategoryData;
                }),
                'total_base' => $total_base,
                'total_point' => $total_score,
                'total_percentage' => $total_base != 0 ? round(($total_score * 100 / $total_base), 0) : 0,
                'overall_score' => ''
            ];
            $category->sub_categ = $sub_category;
            $critical_deviation = CriticalDeviationMenuModel::select('*')
                ->where('critical_deviation_id', $category->critical_deviation)
                ->get();
            $category->critical_deviation = $critical_deviation->map(function ($cd) use ($category, &$total_score, &$saved_critical_score) {
                $dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->dropdown_id)->get()->toArray();
                $location_dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->location_dropdown_id)->get()->toArray();
                $product_dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->product_dropdown_id)->get()->toArray();
                $saved_remarks = '';
                $saved_sd = '';
                $saved_score = '';
                $saved_location = '';
                $saved_product = '';
                $saved_dropdown = '';
                if ($this->audit_status) {
                    $data = CriticalDeviationResultModel::select('*')
                        ->where('form_id', $this->audit_forms_id)
                        ->where('category_id', $category->id)
                        ->where('deviation_id', $cd->id)
                        ->where('critical_deviation_id', $cd->critical_deviation_id)
                        ->first();
                    $saved_remarks = $data ? $data['remarks'] : null;
                    $saved_sd = $data ? $data['sd'] : null;
                    $saved_score = $data ? $data['score'] : null;
                    $saved_location = $data ? $data['location'] : null;
                    $saved_product = $data ? $data['product'] : null;
                    $saved_dropdown = $data ? $data['dropdown'] : null;
                    if ($saved_score) {
                        $percentageInt = intval(str_replace('%', '', $saved_score));
                        $saved_critical_score += $percentageInt;
                    }
                }
                return [
                    'id' => $cd->id,
                    'category_id' => $category->id,
                    'critical_deviation_id' => $cd->critical_deviation_id,
                    'label' => $cd->label,
                    'remarks' => $cd->remarks,
                    'score_dropdown_id' => $cd->score_dropdown_id,
                    'is_sd' => $cd->is_sd,
                    'is_location' => $cd->is_location,
                    'location' => $location_dropdownMenu,
                    'is_product' => $cd->is_product,
                    'product' => $product_dropdownMenu,
                    'is_dropdown' => $cd->is_dropdown,
                    'dropdown_id' => $cd->dropdown_id,
                    'dropdown' => $dropdownMenu,
                    'saved_remarks' => $saved_remarks,
                    'saved_sd' => $saved_sd,
                    'saved_score' => $saved_score,
                    'saved_location' => $saved_location,
                    'saved_product' => $saved_product,
                    'saved_dropdown' => $saved_dropdown,
                ];
            });
            // $sub_category['overall_score'] = $total_base != 0 ? round((($total_score - $saved_critical_score) * 100 / $total_base), 0) : 0;
            $total_percentage = $total_base != 0 ? round(($total_score * 100 / $total_base), 0) : 0;
            $sub_category['overall_score'] = $total_percentage - $saved_critical_score;
            $category->sub_categ = $sub_category;
        }
        $this->category_list = $data;
        // dd($data);
        return view('livewire.store.audit-result', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }
    public function setTime($data)
    {
        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $currentTime = $time->format('h:i A');
        if ($data == 0) {
            $this->cashier_tat[$this->currentIndex][$this->currentField] = $currentTime;
        } else if ($data == 1) {
            $this->server_cat[$this->currentIndex][$this->currentField] = $currentTime;
        }
    }
    public function stopTimer()
    {
        if (empty($this->currentField)) {
            return;
        }
        $currentTime = new DateTime('now', new DateTimeZone('Asia/Manila'));
        $currentTime = date('H:i');
        if ($this->currentField == "product_order_{$this->currentIndex}") {
            $this->cashier_tat[$this->currentIndex]['ot'] = $currentTime;
        }
        $this->currentField = '';
    }
    public function mount($store_id = null)
    {
        $this->store_id = $store_id;
    }
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    public function updatePoints($id = null, $parentIndex = null, $subIndex = null, $childIndex = null, $labelIndex = null, $categoryId = null, $subcategoryId = null, $childId = null, $labelId = null, $is_sub = null, $value = null)
    {
        if (!$this->audit_status) {
            return;
        }
        $dataItems = $this->category_list[$parentIndex]['sub_categ']['data_items'];
        $subCategory = $dataItems[$subIndex]['sub_category'][$childIndex];
        $bp = $is_sub ? $subCategory['label'][$labelIndex]['bp'] : $subCategory['bp'];
        $is_all = $is_sub ? $subCategory['label'][$labelIndex]['is_all_nothing'] : $subCategory['is_all_nothing'];
        $this->dispatchBrowserEvent('checkPoints', [
            'id' => $id,
            'value' => $value,
            'points' => $bp,
            'is_all' => $is_all,
        ]);
        $validated_points = max(0, min($value, $bp));
        $query = AuditFormResultModel::where('form_id', $this->audit_forms_id)
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subcategoryId)
            ->where('sub_sub_category_id', $childId);
        if ($is_sub) {
            $query->where('label_id', $labelId)
                ->update(['label_point' => $validated_points]);
        } else {
            $query->update(['sub_sub_point' => $validated_points]);
        }
    }
    public function updateRemarks($categoryId = null, $subcategoryId = null, $childId = null, $labelId = null, $is_sub = null, $value = null)
    {
        if (!$this->audit_status) {
            return;
        }
        $query = AuditFormResultModel::where('form_id', $this->audit_forms_id)
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subcategoryId)
            ->where('sub_sub_category_id', $childId);
        if ($is_sub) {
            $query->where('label_id', $labelId)
                ->update(['label_remarks' => $value]);
        } else {
            $query->update(['sub_sub_remarks' => $value]);
        }
    }
    public function updateDeviation($categoryId = null, $subcategoryId = null, $childId = null, $labelId = null, $is_sub = null, $value = null)
    {
        if (!$this->audit_status) {
            return;
        }
        $query = AuditFormResultModel::where('form_id', $this->audit_forms_id)
            ->where('category_id', $categoryId)
            ->where('sub_category_id', $subcategoryId)
            ->where('sub_sub_category_id', $childId);
        if ($is_sub) {
            $query->where('label_id', $labelId)
                ->update(['label_deviation' => $value]);
        } else {
            $query->update(['sub_sub_deviation' => $value]);
        }
    }
    public function addInput($data)
    {
        $add = [
            'name' => '',
            'time' => '',
            'product_order' => '',
            'ot' => '',
            'ot_point' => 1,
            'fst' => '',
            'fst_point' => 3,
            'remarks' => '',
        ];
        if ($data == 0) {
            $add['tat'] = '';
            $add['tat_point'] = 1;
            array_push($this->cashier_tat, $add);
        } else if ($data == 1) {
            $add['cat'] = '';
            $add['tat_point'] = 1;
            array_push($this->server_cat, $add);
        }
    }
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        if ($this->audit_status) {
            $message = 'Are you sure you want to complete this audit?';
        } else {
            $message = 'Are you sure you want to start this audit?';
        }
        $this->emit('onStartAlert', $message);
    }
    public function onUpdateStatus()
    {
        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $date_today = $time->format('Y-m-d');
        $audit_time = $time->format('h:i');
        $data = $this->audit_status ? false : true;
        StoreModel::where('id', $this->store_id)->update([
            'audit_status' => $data,
        ]);
        AuditFormModel::updateOrCreate(
            ['id' => $this->audit_forms_id],
            [
                'store_id' => $this->store_id,
                'date_of_visit' => $date_today,
                'conducted_by_id' => Auth::user()->id,
                'received_by' => '',
                'time_of_audit' => $audit_time,
                'audit_status' => $data,
            ]
        );
        return redirect()->route('form.summary', ['store_id' => $this->store_id]);
    }
    public function updateCriticalDeviation($data = null, $value = null, $deviation = null)
    {
        if (!$this->audit_status) {
            return;
        }
        $query = CriticalDeviationResultModel::where('form_id', $this->audit_forms_id)
            ->where('category_id', $data['category_id'])
            ->where('deviation_id', $data['id'])
            ->where('critical_deviation_id', $data['critical_deviation_id']);
        if ($deviation == "remarks") {
            $query->update(['remarks' => $value]);
        } else if ($deviation == "dropdown") {
            $query->update(['dropdown' => $value]);
        } else if ($deviation == "score") {
            $query->update(['score' => $value]);
        } else if ($deviation == "sd") {
            $query->update(['sd' => $value]);
        } else if ($deviation == "location") {
            $query->update(['location' => $value]);
        } else if ($deviation == "product") {
            $query->update(['product' => $value]);
        }
    }
}
