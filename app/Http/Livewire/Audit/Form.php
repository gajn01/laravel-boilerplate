<?php

namespace App\Http\Livewire\Audit;

use App\Models\AuditDate;
use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\AuditForm as AuditFormModel;
use App\Models\AuditFormResult as AuditFormResultModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;
use App\Models\Summary as SummaryModel;
use App\Models\AuditDate as AuditDateModel;
use App\Models\ServiceSpeed as ServiceSpeedModel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
use DateTime;
use DateTimeZone;

class Form extends Component
{
    public $active_index = 0;
    protected $listeners = ['alert-sent' => 'onUpdateStatus', 'start-alert-sent' => 'onUpdateStatus'];
    public $store;
    public $store_id;
    public $store_name;
    /* Audit Category */
    public $dov;
    public $category_list;
    public $store_type;
    public $sanitation_defect;
    public $audit_status;
    public $audit_forms_id;
    public $actionTitle = 'Start';
    public $currentField;
    public $currentIndex = 0;
    public $is_na = [];
    public $wave;
    public $cashier_tat;
    public $server_cat;
    public $score = [
        ['name' => '3'],
        ['name' => '5'],
        ['name' => '10'],
        ['name' => '15']
    ];
    private $timezone;
    private $time;
    private $date_today;
    protected $rules = [
        'category_list.*.sub_categ.data_items.*.id' => 'required',
        'category_list.*.sub_categ.data_items.*.name' => 'required',
        'category_list.*.sub_categ.data_items.*.sub_category.*.*' => 'required',
    ];
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
    }
    public function render()
    {
        $service = ServiceSpeedModel::where('form_id', $this->audit_forms_id)
            ->whereIn('is_cashier', [0, 1])
            ->get();
        $this->cashier_tat = $service->where('is_cashier', 1);
        $this->server_cat = $service->where('is_cashier', 0);
        $this->dov = $this->date_today;
        $result = AuditDateModel::select('wave')
            ->where('store_id', $this->store_id)
            ->where('audit_date', $this->date_today)
            ->first();
        $this->wave = $result ? $result->wave : null;
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();
        $store = StoreModel::find($this->store_id);
        $this->store = $store;
        $this->store_name = $store->name;
        $this->store_type = $store->type;
        $this->audit_status = $store->audit_status;
        $this->actionTitle = $this->audit_status ? 'Save' : 'Start';
        $data = CategoryModel::where('type', $this->store_type)
            ->orderBy('type', 'DESC')
            ->orderBy('order', 'ASC')
            ->with([
                'subCategories.subCategoryLabels' => function ($query) {
                    $query->selectRaw('id, name, is_all_nothing, bp, sub_category_id, dropdown_id');
                },
            ])->get();
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
                        $saved_na = '';
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
                            $saved_na = $data['is_na'];
                        } else {
                            $saved_point = $label->bp;
                        }

                        /*    $totalPoints = ServiceSpeedModel::selectRaw('is_cashier, SUM(assembly_points + tat_points + fst_points) AS total_points, SUM(base_assembly_points + base_tat_points + base_fst_points) AS base_total')
                               ->groupBy('is_cashier')
                               ->get();
                           dd($totalPoints); */

                        $dropdownMenu = DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray();
                        $isAllNothing = $label->is_all_nothing;
                        $total_base += $label->bp;
                        $total_bp += $label->bp;
                        $total_points += $saved_point;
                        $total_score += $saved_point;
                        if ($saved_na) {
                            $total_base -= $label->bp;
                            $total_bp -= $label->bp;
                            $total_points -= $saved_point;
                            $total_score -= $label->points;

                        }
                        // $this->is_na[$label->id] = $saved_na;
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
                            'is_na' => $saved_na,
                        ];
                    }) : $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_points, &$total_base, &$total_score, &$category_id, &$sub_category_id, &$sub_sub_category_id, ) {
                        $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                        $subLabelData = $subLabels->map(function ($subLabel) use (&$total_bp, &$total_points, &$total_base, &$total_score, &$category_id, &$sub_category_id, &$sub_sub_category_id, ) {
                            $sub_sub_category_id = $subLabel->sub_sub_category_id;
                            $subLabel->id;
                            $saved_point = 0;
                            $saved_remarks = '';
                            $saved_deviation = '';
                            $saved_na = '';

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
                                $saved_na = $data ? $data['is_na'] : 0;
                            } else {
                                $saved_point = $subLabel->bp;
                            }
                            $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                            $isAllNothing = $subLabel->is_all_nothing;
                            $total_bp += $subLabel->bp;
                            $total_base += $subLabel->bp;
                            $total_points += $saved_point;
                            $total_score += $saved_point;
                            if ($saved_na) {
                                $total_base -= $subLabel->bp;
                                $total_bp -= $subLabel->bp;
                                $total_points -= $saved_point;
                                $total_score -= $subLabel->points;
                            }
                            return [
                                'id' => $subLabel->id,
                                'name' => $subLabel->name,
                                'bp' => $subLabel->bp,
                                'is_all_nothing' => $isAllNothing,
                                'points' => $saved_point,
                                'remarks' => $saved_remarks,
                                'deviation' => $saved_deviation,
                                'dropdown' => $dropdownMenu,
                                'is_na' => $saved_na,

                            ];
                        });
                        return [
                            'id' => $label->id,
                            'name' => $label->name,
                            'label' => $subLabelData,
                        ];
                    });


                    $subCategoryData['base_score'] = $total_bp;
                    $subCategoryData['total_point'] = $total_points;
                    $subCategoryData['total_percent'] = $total_bp != 0 ? round(($total_points * 100 / $total_bp), 0) : 0;
                    $service_points = ServiceSpeedModel::selectRaw(' SUM(assembly_points + tat_points + fst_points) AS total_points, SUM(base_assembly_points + base_tat_points + base_fst_points) AS base_total')->where('form_id', $this->audit_forms_id)->first();

                    if ($subCategory->name == "Speed and Accuracy") {

                        $total_base += $service_points->base_total ? $service_points->base_total : 0;
                        $total_score += $service_points->base_total ? $service_points->total_points : 0;
                        $subCategoryData['base_score'] = $service_points->base_total ? $service_points->base_total : 0;
                        $subCategoryData['total_point'] = $service_points->base_total ? $service_points->total_points : 0;
                        $subCategoryData['total_percent'] = $service_points->base_total != 0 ? round(($service_points->total_points * 100 / $service_points->base_total), 0) : 0;
                    }
                    $subCategoryData['total_base'] = $total_base;
                    $subCategoryData['total_score'] = $total_score;

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
                ->where('critical_deviation_id', $category->critical_deviation_id)
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
        // dd($this->category_list);
        return view('livewire.audit.form', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }
    public function setTime($data)
    {
        $currentTime = $this->time->format('H:i');
        $targetDateTime = $data == 0 ? $this->cashier_tat[$this->currentIndex][$this->currentField] : $this->server_cat[$this->currentIndex][$this->currentField];
        if ($data == 0) {
            $this->cashier_tat[$this->currentIndex][$this->currentField] = $currentTime;
            $this->updateService($this->cashier_tat[$this->currentIndex] , $this->currentField, $this->cashier_tat[$this->currentIndex][$this->currentField]);
            if($this->currentField == 'tat'){
                $targetTimestamp = strtotime($this->cashier_tat[$this->currentIndex]['time']);
                $diff = strtotime($targetDateTime) - $targetTimestamp;
                $pts = ($diff > 60) ? 0 : 1;
                $this->updateService($this->cashier_tat[$this->currentIndex], 'tat_points', $pts);
            }else if($this->currentField == 'fst'){
                $serving_time = $this->cashier_tat[$this->currentIndex]['serving_time'];
                $targetTimestamp = strtotime($this->cashier_tat[$this->currentIndex]['tat']);
                $diff = strtotime($targetDateTime) - $targetTimestamp;
                $pts = ($diff >  ($serving_time - 1)  * 60) ? 0 : 3;
                $this->updateService($this->cashier_tat[$this->currentIndex], 'fst_points', $pts);
            }
        }else{
            $this->server_cat[$this->currentIndex][$this->currentField] = $currentTime;
            $this->updateService($this->server_cat[$this->currentIndex] , $this->currentField, $this->server_cat[$this->currentIndex][$this->currentField]);
            if($this->currentField == 'tat'){
                $targetTimestamp = strtotime($this->server_cat[$this->currentIndex]['time']);
                $diff = strtotime($targetDateTime) - $targetTimestamp;
                $pts = ($diff > 60) ? 0 : 1;
                $this->updateService($this->server_cat[$this->currentIndex], 'tat_points', $pts);
            }else if($this->currentField == 'fst'){
                $serving_time = $this->server_cat[$this->currentIndex]['serving_time'];
                $targetTimestamp = strtotime($this->server_cat[$this->currentIndex]['tat']);
                $diff = strtotime($targetDateTime) - $targetTimestamp;
                $pts = ($diff >  ($serving_time - 1)  * 60) ? 0 : 3;
                $this->updateService($this->server_cat[$this->currentIndex], 'fst_points', $pts);
            }
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
        $this->audit_forms_id = AuditFormModel::where('store_id', $this->store_id)->where('date_of_visit', $this->date_today)->value('id');
    }
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    public function updateNa($id = null, $parentIndex = null, $subIndex = null, $childIndex = null, $labelIndex = null, $categoryId = null, $subcategoryId = null, $childId = null, $labelId = null, $points = null, $is_sub = null, $value = null)
    {

        $val = $value ? $points : 0;
        if ($this->audit_status) {
            $query = AuditFormResultModel::where('form_id', $this->audit_forms_id)
                ->where('category_id', $categoryId)
                ->where('sub_category_id', $subcategoryId)
                ->where('sub_sub_category_id', $childId);
            if ($is_sub) {
                $query->where('label_id', $labelId)
                    ->update(['is_na' => $value ? 0 : 1, 'label_point' => $val]);
            } else {
                $query->update(['is_na' => $value ? 0 : 1, 'sub_sub_point' => $val]);
            }
        }
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
        $data = ['form_id' => $this->audit_forms_id, 'is_cashier' => $data, 'name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'base_assembly_points' => 1, 'assembly_points' => 1, 'tat' => null, 'base_tat_points' => 1, 'tat_points' => 1, 'fst' => null, 'base_fst_points' => 3, 'fst_points' => 3, 'remarks' => null, 'serving_time' => '5'];
        ServiceSpeedModel::create($data);
    }
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        if ($this->audit_status) {
            $message = 'Are you sure you want to save this audit?';
        } else {
            $message = 'Are you sure you want to start this audit?';
        }
        $this->emit('onStartAlert', $message);
    }
    public function onUpdateStatus()
    {
        $auditData = AuditDateModel::where('store_id', $this->store_id)
            ->where('audit_date', $this->date_today)->first();
        if(!$auditData){
             return $this->onAlert(false, 'Warning', 'The store is not scheduled for today`s audit. Please proceed with regular operations!', 'warning');
        }
        $audit_time = $this->time->format('h:i');
        $data = $this->audit_status ? false : true;
        $audit_form = AuditFormModel::updateOrCreate(
            [
                'store_id' => $this->store_id,
                'date_of_visit' => $this->date_today
            ],
            [
                'audit_date_id' => $auditData['id'],
                'conducted_by_id' => Auth::user()->id,
                'received_by' => '',
                'time_of_audit' => $audit_time,
                'audit_status' => $data,
                'wave' => $this->wave,
            ]
        );
        $this->audit_forms_id = $audit_form->id;
        if ($data) {
            $this->onInitialSave();
            StoreModel::where('id', $this->store_id)
                ->update(['audit_status' => $data]);
            $auditData->update([
                'is_complete' => 1,
            ]);
        } else {
            $summary = SummaryModel::updateOrCreate(
                [
                    'form_id' => $this->audit_forms_id,
                    'store_id' => $this->store_id,
                    'date_of_visit' => $this->date_today,
                ],
                [
                    'store_id' => $this->store_id,
                    'form_id' => $this->audit_forms_id,
                    'name' => $this->store->name,
                    'code' => $this->store->code,
                    'type' => $this->store->type,
                    'wave' => $this->wave,
                    'conducted_by' => Auth::user()->name,
                    'received_by' => null,
                    'date_of_visit' => $this->dov,
                    'time_of_audit' => $audit_time,
                    'strength' => '',
                    'improvement' => '',
                ]
            );
            redirect()->route('audit.view.result', ['store_id' => $this->store_id, 'result_id' => $summary->id]);
        }
    }
    public function onInitialSave()
    {
        $auditResults = collect($this->category_list)->flatMap(function ($data) {
            return collect($data->sub_categ['data_items'])->flatMap(function ($sub) use ($data) {
                return collect($sub['sub_category'])->map(function ($child) use ($data, $sub) {
                    $result = [
                        'form_id' => $this->audit_forms_id,
                        'category_id' => $data->id,
                        'category_name' => $data->name,
                        'sub_category_id' => $sub['id'],
                        'sub_name' => $sub['name'],
                        'sub_sub_category_id' => $child['id'],
                        'sub_sub_name' => $child['name'],
                        'sub_sub_base_point' => $child['bp'] ?? null,
                        'sub_sub_point' => $child['points'] ?? null,
                        'sub_sub_remarks' => $child['remarks'] ?? null,
                        'sub_sub_file' => $child['tag'] ?? null,
                        'is_na' => '0'
                    ];
                    if (isset($child['label'])) {
                        return collect($child['label'])->map(function ($label) use ($result) {
                            return array_merge($result, [
                                'label_id' => $label['id'],
                                'label_name' => $label['name'],
                                'label_base_point' => $label['bp'] ?? null,
                                'label_point' => $label['points'] ?? null,
                                'label_remarks' => $label['remarks'] ?? null,
                                'label_file' => $label['tag'] ?? null,
                            ]);
                        });
                    } else {
                        return [$result];
                    }
                });
            });
        })->flatten(1);
        $critical_deviation = collect($this->category_list)->flatMap(function ($data) {
            $deviations = CriticalDeviationMenuModel::where('critical_deviation_id', $data->critical_deviation_id)->get();
            return collect($deviations)->map(function ($dev) use ($data) {
                $result = [
                    'form_id' => $this->audit_forms_id,
                    'deviation_id' => $dev->id,
                    'category_id' => $data->id,
                    'critical_deviation_id' => $dev->critical_deviation_id,
                    'remarks' => null,
                    'score' => null,
                    'sd' => null,
                    'location' => null,
                    'product' => null,
                    'dropdown' => null,
                ];
                return [$result];
            });
        })->flatten(1);
        $critical_deviation->each(function ($result) {
            if (is_array($result)) {
                CriticalDeviationResultModel::create($result);
            }
        });
        $auditResults->each(function ($result) {
            if (is_array($result)) {
                AuditFormResultModel::create($result);
            }
        });
        /*         $data = [
                    ['form_id' => $this->audit_forms_id, 'is_cashier' => 1, 'name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'base_assembly_points' => 1, 'assembly_points' => 1, 'tat' => null, 'base_tat_points' => 1, 'tat_points' => 1, 'fst' => null, 'base_fst_points' => 3, 'fst_points' => 3, 'remarks' => null],
                    ['form_id' => $this->audit_forms_id, 'is_cashier' => 0, 'name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'base_assembly_points' => 1, 'assembly_points' => 1, 'tat' => null, 'base_tat_points' => 1, 'tat_points' => 1, 'fst' => null, 'base_fst_points' => 3, 'fst_points' => 3, 'remarks' => null],
                ];
                foreach ($data as $speed) {
                    ServiceSpeedModel::create($speed);
                } */
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
    public function updateService($data, $key, $value)
    {
        $query = ServiceSpeedModel::find($data['id']);
        if ($query) {
            if ($value >= 0) {
                $newValue = isset($data['base_' . $key]) && intval($value) > $data['base_' . $key] ? $data['base_' . $key] : $value;
                $query->update([
                    $key => $newValue
                ]);
            }
        }
    }
    public function removeService($id)
    {
    }

    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
}