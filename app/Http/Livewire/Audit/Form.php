<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
/*  */
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
/* models  */
use App\Models\Store;
use App\Models\AuditForm;
use App\Models\AuditDate;
use App\Models\Summary;

use App\Models\AuditFormResult;


use App\Models\Category;
use App\Models\DropdownMenu;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\SanitaryModel;
use App\Models\CriticalDeviationMenu;
use App\Models\CriticalDeviationResult;

use App\Models\ServiceSpeed as ServiceSpeedModel;
use DateTime;
use DateTimeZone;

class Form extends Component
{
    protected $listeners = ['start-alert-sent' => 'onUpdateStatus'];
    private $timezone, $time, $date_today;
    public $active_index = 0;
    public $sanitary_list;
    public AuditForm $auditForm;
    public AuditDate $auditDate;
    public Store $store;
    public Summary $summary;
    public $score = [
        ['name' => '3'],
        ['name' => '5'],
        ['name' => '10'],
        ['name' => '15']
    ];
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->initialize();
    }
    public function mount($id = null)
    {
        $this->sanitary_list = SanitaryModel::get();
        $this->store = Store::find($id);
    }
    public function render()
    {
        $this->auditDate = AuditDate::where('store_id', $this->store->id)->where('audit_date', $this->date_today)->first();
        $this->auditForm = AuditForm::where('store_id', $this->store->id)->where('date_of_visit', $this->date_today)->first();
        $category = $this->mapCategory();
        return view('livewire.audit.form', ['categoryList' => $category])->extends('layouts.app');
    }
    public function onStartAudit()
    {
        $message = 'Are you sure you want to start this audit?';
        $this->emit('onStartAlert', $message);
    }
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    #region Set up Audit Forms
    public function mapCategory()
    {
        $data = $this->getCategoryList();
        foreach ($data as $category) {
            $category_id = $category->id;
            $saved_critical_score = 0;
            $total_base = 0;
            $total_score = 0;
            $category->critical_deviation = $this->mapDeviation($category_id, $category->critical_deviation_id);
            $category->sub_category->transform(function ($subCategory) use ($category_id, &$total_base, &$total_score) {
                $sub_category_id = $subCategory->id;
                $total_base += $this->getTotalBp($subCategory);
                // $total_score += $this->getTotalScore($subCategory);

                $subCategoryData = [
                    'id' => $subCategory->id,
                    'is_sub' => $subCategory->is_sub,
                    'name' => $subCategory->name,
                    'total_base_per_category' => $this->getTotalBp($subCategory),
                    'total_points_per_category' => $this->getTotalScore($subCategory,$category_id, $sub_category_id),
                    'total_base' => $total_base,
                    // Sum to total_base
                    'total_points' => $total_score,
                    'total_score' => $total_score,
                ];
                $subCategoryData['sub_sub_category'] = $this->getSubSubCategory($subCategory, $category_id, $sub_category_id);
                return $subCategoryData;
            });
        }
        return $data;
    }
    public function getTotalBp($subCategory)
    {
        if ($subCategory->is_sub == 0) {
            return $subCategory->sub_sub_category->sum('bp');
        } else {
            return $subCategory->sub_sub_category->flatMap(function ($subSubCategory) {
                return $subSubCategory->sub_sub_sub_category->pluck('bp');
            })->sum();
        }
    }
    public function getTotalScore($subCategory,$category_id, $sub_category_id)
    {
        $data = $this->getSubSubCategory($subCategory, $category_id, $sub_category_id);
        dd($data);
        if ($subCategory->is_sub == 0) {
            return $data->sum('points');
        } else {
            return $data->flatMap(function ($subSubCategory) {
                return $subSubCategory->sub_sub_sub_category->pluck('points');
            })->sum();
        }
    }
    public function mapDeviation($category_id, $critical_deviation_id)
    {
        return $this->getDeviationList($critical_deviation_id)->transform(function ($deviation) use ($category_id, $critical_deviation_id) {
            if ($this->store->audit_status) {
                $result = $this->getDeviationResult($category_id, $deviation->id, $critical_deviation_id);
            }
            return [
                'id' => $deviation->id,
                'label' => $deviation->label,
                'remarks' => $deviation->remarks,
                'score_dropdown_id' => $deviation->score_dropdown_id,
                'score' => '',
                'is_sd' => $deviation->is_sd,
                'is_location' => $deviation->is_location,
                'location' => $this->getDropdownList($deviation->location_dropdown_id),
                'is_product' => $deviation->is_product,
                'product' => $this->getDropdownList($deviation->product_dropdown_id) ?? null,
                'is_dropdown' => $deviation->is_dropdown,
                'dropdown' => $this->getDropdownList($deviation->dropdown_id) ?? null,
                'saved_sd' => $result ? $result['sd'] : null,
                'saved_remarks' => $result ? $result['remarks'] : null,
                'saved_score' => $result ? $result['score'] : null,
                'saved_location' => $result ? $result['location'] : null,
                'saved_product' => $result ? $result['product'] : null,
                'saved_dropdown' => $result ? $result['dropdown'] : null,
            ];
        });
    }
    public function getResult($category_id, $sub_category_id, $label_id)
    {
        return AuditFormResult::where('form_id', $this->auditForm->id)
            ->where('category_id', $category_id)
            ->where('sub_category_id', $sub_category_id)
            ->where('sub_sub_category_id', $label_id)
            ->first();
    }
    public function getDeviationResult($category_id, $deviation_id, $critical_deviation_id)
    {
        return CriticalDeviationResult::where('form_id', $this->auditForm->id)
            ->where('category_id', $category_id)
            ->where('deviation_id', $deviation_id)
            ->where('critical_deviation_id', $critical_deviation_id)
            ->first();
    }
    public function getSubSubCategory($subCategory, $category_id, $sub_category_id)
    {
        $is_sub = $subCategory->is_sub;
        $subCategory->sub_sub_category->transform(function ($label) use ($is_sub, $category_id, $sub_category_id) {
            $result = null;
            if ($this->store->audit_status) {
                $result = $this->getResult($category_id, $sub_category_id, $label->id);
            }
            $data = [
                'id' => $label->id,
                'name' => $label->name,
                'bp' => $label->bp,
                'points' => $result ? $result['sub_sub_point'] : 0,
            ];
            if ($is_sub == 0) {
                $data['is_all_nothing'] = $label->is_all_nothing;
                $data['remarks'] = $result ? $result['sub_sub_remarks'] : null;
                $data['deviation'] = $result ? $result['sub_sub_deviation'] : null;
                $data['is_na'] = $result['is_na'] ?? 0;
                $data['dropdown'] = $this->getDropdownList($label->dropdown_id) ?? null;
            } else {
                $data['sub_sub_sub_category'] = $this->getSubSubSubCategory($label->sub_sub_sub_category, $category_id, $sub_category_id, $label->id);
            }
            return $data;
        });
        return $subCategory->sub_sub_category;
    }
    public function getSubSubSubCategory($sub_sub_sub_category, $category_id = null, $sub_category_id = null, $sub_sub_sub_category_id = null)
    {
        $sub_sub_sub_category->transform(function ($label) use ($category_id, $sub_category_id, $sub_sub_sub_category_id) {
            if ($this->store->audit_status) {
                $result = $this->getResult($category_id, $sub_category_id, $sub_sub_sub_category_id);
            }
            return [
                'id' => $label->id,
                'name' => $label->name,
                'bp' => $label->bp,
                'points' => $result ? $result['label_point'] : 0,
                'is_all_nothing' => $label->is_all_nothing,
                'remarks' => $result ? $result['label_remarks'] : null,
                'deviation' => $result ? $result['label_deviation'] : null,
                'is_na' => $result['is_na'] ?? 0,
                'dropdown' => $this->getDropdownList($label->dropdown_id) ?? null
            ];
        });
        return $sub_sub_sub_category;
    }
    public function getDeviationList($deviation_id)
    {
        return CriticalDeviationMenu::where('critical_deviation_id', $deviation_id)->get();
    }
    public function getDropdownList($id)
    {
        return DropdownMenu::where('dropdown_id', $id)->get()->toArray();
    }
    public function getCategoryList()
    {
        return Category::where('type', $this->store->type)->orderBy('type', 'DESC')->orderBy('order', 'ASC')->get();
    }
    #endregion

    #region intialization
    public function initialize()
    {
        $this->store = new Store;
        $this->auditForm = new AuditForm;
        $this->auditDate = new AuditDate;
        $this->summary = new Summary;
    }
    #endregion

    #region Update Audit form,date,summary
    public function onUpdateStatus()
    {
        $this->updateStatus();
        $this->updateAuditForm();
        $this->updateOrCreateSummary();
    }
    private function updateStatus()
    {
        $this->store->audit_status = 1;
        $this->store->save();
        $this->auditDate->is_complete = 1;
        $this->auditDate->save();
    }
    private function updateAuditForm()
    {
        $this->auditForm = AuditForm::updateOrCreate(
            [
                'store_id' => $this->store->id,
                'date_of_visit' => $this->date_today
            ],
            [
                'audit_date_id' => $this->auditDate->id,
                'conducted_by_id' => Auth::user()->id,
                'time_of_audit' => $this->time->format('h:i'),
                'audit_status' => $this->store->audit_status,
                'wave' => $this->auditDate->wave,
            ]
        );
    }
    public function updateOrCreateSummary()
    {
        $this->summary = Summary::updateOrCreate(
            [
                'form_id' => $this->auditForm->id,
                'store_id' => $this->store->id,
                'date_of_visit' => $this->date_today,
            ],
            [
                'name' => $this->store->name,
                'code' => $this->store->code,
                'type' => $this->store->type,
                'wave' => $this->auditDate->wave,
                'conducted_by' => Auth::user()->name,
                'received_by' => null,
                'time_of_audit' => $this->time->format('h:i'),
            ]
        );
    }
    #endregion
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
}