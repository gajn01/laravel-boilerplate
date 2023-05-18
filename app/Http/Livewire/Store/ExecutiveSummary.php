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
use App\Models\Summary as SummaryModel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;

use DateTime;
use DateTimeZone;

class ExecutiveSummary extends Component
{
    public $active_index = 0;
    protected $listeners = ['alert-sent' => 'onUpdateStatus', 'start-alert-sent' => 'onUpdateStatus'];
    public $store;
    public $store_id;
    /* Audit Category */
    public $category_list;
    public $store_type;
    public $sanitation_defect;
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
    public function render()
    {

        $timezone = new DateTimeZone('Asia/Manila');
        $time = new DateTime('now', $timezone);
        $date_today = $time->format('Y-m-d');
        $this->dov = $date_today;
        $this->conducted_by = Auth::user()->name;
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();

        $this->audit_forms_id = AuditFormModel::where('store_id', $this->store_id)->value('id');
        $store = StoreModel::find($this->store_id);
        $this->store = $store;
        $this->store_type = $store->type;
        $this->audit_status = $store->audit_status;
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
        // dd($this->category_list);
        return view('livewire.store.executive-summary', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }

    public function mount($store_id = null)
    {
        $this->store_id = $store_id;
    }
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        $message = 'Are you sure you want to complete this audit?';
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
    }

    public function onComplete()
    {
        $this->validate(
            [
                'with' => '',
                'conducted_by' => '',
                'received_by' => 'required',
                'dov' => '',
                'toa' => '',
                'strength' => 'required',
                'improvement' => 'required',
                'wave' => 'required',
            ]
        );
        SummaryModel::create([
            'store_id' => strip_tags($this->store_id),
            'name' => strip_tags($this->store->name),
            'code' => strip_tags($this->store->code),
            'type' => strip_tags($this->store->type),
            'wave' => strip_tags($this->wave),
            'with' => strip_tags($this->with),
            'conducted_by' => strip_tags($this->conducted_by),
            'received_by' => strip_tags($this->received_by),
            'date_of_visit' => strip_tags($this->dov),
            'time_of_audit' => strip_tags($this->toa),
            'strength' => strip_tags($this->strength),
            'improvement' => strip_tags($this->improvement),
        ]);

        StoreModel::where('id', $this->store_id)->update([
            'audit_status' => 0,
        ]);
        $this->reset();
        $this->onAlert(false, 'Success', 'Audit record saved successfully!', 'success');
        return redirect()->route('details', ['store_id' => $this->store_id]);
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
