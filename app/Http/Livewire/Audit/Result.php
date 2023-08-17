<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
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
use App\Models\SanitaryModel;
use App\Models\CriticalDeviationMenu;
use App\Models\CriticalDeviationResult;
use App\Models\ServiceSpeed;
use DateTime;
use DateTimeZone;

class Result extends Component
{
    private $timezone, $time, $date_today;
    public $cashier_tat, $server_cat;
    public $active_index = 0;
    public $score = [['name' => '3'],['name' => '5'],['name' => '10'],['name' => '15']];
    public AuditForm $auditForm;
    public AuditDate $auditDate;
    public Store $store;
    public Summary $summary;
    public AuditFormResult $auditResult;
    public ServiceSpeed $serviceSpeed;
    public CriticalDeviationResult $criticalDeviationResult;
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->initialize();
    }
    public function mount($store_id = null, $summary_id = null)
    {
        $this->store = Store::find($store_id);
        $this->summary = Summary::find($summary_id);
    }
    public function render()
    {
        // $this->auditDate = AuditDate::where('store_id', $this->store->id)->where('audit_date', $this->date_today)->first();
        $this->auditForm = AuditForm::where('store_id', $this->store->id)->where('date_of_visit', $this->date_today)->first();
        $service = $this->getService();
        $this->cashier_tat = $service->where('is_cashier', 1);
        $this->server_cat = $service->where('is_cashier', 0);
        $category = $this->mapCategory();
        return view('livewire.audit.result', ['categoryList' => $category])->extends('layouts.app');
    }
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    #region intialization
    public function initialize()
    {
        $this->store = new Store;
        $this->auditForm = new AuditForm;
        // $this->auditDate = new AuditDate;
        $this->summary = new Summary;
        $this->auditResult = new AuditFormResult;
        $this->serviceSpeed = new ServiceSpeed;
    }
    #endregion
    #region Setup Category
    public function mapCategory()
    {
        $data = $this->getCategoryList();
        foreach ($data as $category) {
            $category_id = $category->id;
            $total_base = 0;
            $total_points = 0;
            $total_percent = 0;
            $category->critical_deviation = $this->mapDeviation($category_id, $category->critical_deviation_id);
            $category->sub_category->transform(function ($subCategory) use ($category, $category_id, &$total_base, &$total_points, &$total_percent) {
                $sub_category_id = $subCategory->id;
                $subCategory->points = 0;
                $sub_sub_category = $this->getSubSubCategory($subCategory, $category_id, $sub_category_id);
                $total_base += $this->getTotalBp($subCategory);
                $total_points += $this->getTotalScore($subCategory['is_sub'], $sub_sub_category);
                if ($subCategory['name'] == "Speed and Accuracy") {
                    $total_base_per_category = $this->getServiceResultList()->base_total;
                    $total_points_per_category = $this->getServiceResultList()->total_points;
                    $total_base += $total_base_per_category;
                    $total_points += $total_points_per_category;
                    $total_percentage_per_category = $this->getPercentage($category_id, $subCategory, $total_base_per_category, $total_points_per_category);
                } else {
                    $total_base_per_category = $this->getTotalBp($subCategory);
                    $total_points_per_category = $this->getTotalScore($subCategory['is_sub'], $sub_sub_category);
                    $total_percentage_per_category = $this->getPercentage($category_id, $subCategory, $this->getTotalBp($subCategory), $this->getTotalScore($subCategory['is_sub'], $sub_sub_category));
                }
                if ($category_id == 2) {
                    $total_percent += $this->getPercentage($category_id, $subCategory, $this->getTotalBp($subCategory), $this->getTotalScore($subCategory['is_sub'], $sub_sub_category));
                } else {
                    $total_percent = ($total_base == 0) ? 0 : round(($total_points / $total_base) * 100, 0);
                }
                $subCategoryData = [
                    'id' => $subCategory['id'],
                    'is_sub' => $subCategory['is_sub'],
                    'name' => $subCategory['name'],
                    'total_base_per_category' => $total_base_per_category,
                    'total_points_per_category' => $total_points_per_category,
                    'total_percentage_per_category' => $total_percentage_per_category,
                    'total_base' => $total_base,
                    'total_points' => $total_points,
                    'total_percentage' => $total_percent - $this->mapDeviation($category_id, $category->critical_deviation_id)->sum('saved_score'),
                ];
                $subCategoryData['sub_sub_category'] = $sub_sub_category;
                return $subCategoryData;
            });
        }
        return $data;
    }
    public function mapDeviation($category_id, $critical_deviation_id)
    {
        $result = null;
        return $this->getDeviationList($critical_deviation_id)->transform(function ($deviation) use ($category_id, $critical_deviation_id, $result) {
            if ($this->store->audit_status) {
                $result = $this->getDeviationResultList($category_id, $deviation->id, $critical_deviation_id);
            } else{
                $this->auditForm->id =  $this->getStoreRecord()->form_id;
                $result = $this->getDeviationResultList($category_id, $deviation->id, $critical_deviation_id);
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
    public function getSubSubCategory($subCategory, $category_id, $sub_category_id)
    {
        $is_sub = $subCategory->is_sub;
        return $subCategory->sub_sub_category->transform(function ($label) use ($is_sub, $category_id, $sub_category_id) {
            $result = null;
            if ($this->store->audit_status) {
                $result = $this->getResultList($category_id, $sub_category_id, $label['id']);
            }else{
                $this->auditForm->id =  $this->getStoreRecord()->form_id;
                $result = $this->getResultList($category_id, $sub_category_id, $label['id']);
            }
            if ($is_sub == 0 && $result && $result['is_na'] == 1) {
                $result['sub_sub_point'] = 0;
                $label['bp'] = 0;
            }
            $data = [
                'id' => $label['id'],
                'name' => $label['name'],
                'bp' => $label['bp'],
                'points' => $result ? $result['sub_sub_point'] : 0,
                'result_id' => $result ? $result['id'] : 0,
            ];
            if ($is_sub == 0) {
                $data['is_all_nothing'] = $label['is_all_nothing'];
                $data['remarks'] = $result ? $result['sub_sub_remarks'] : null;
                $data['deviation'] = $result ? $result['sub_sub_deviation'] : null;
                $data['is_na'] = $result ? $result['is_na'] : 0;
                $data['dropdown'] = $this->getDropdownList($label['dropdown_id'] ?? null) ?? null;
            } else {
                $data['sub_sub_sub_category'] = $this->getSubSubSubCategory($label['sub_sub_sub_category'], $category_id, $sub_category_id, $label['id']);
            }
            return $data;
        });
    }
    public function getSubSubSubCategory($sub_sub_sub_category, $category_id = null, $sub_category_id = null, $sub_sub_sub_category_id = null)
    {
        $result = null;
        $sub_sub_sub_category->transform(function ($label) use ($category_id, $sub_category_id, $sub_sub_sub_category_id, $result) {
            if ($this->store->audit_status) {
                $result = $this->getResultList($category_id, $sub_category_id, $sub_sub_sub_category_id, $label->id);
            }else{
                $this->auditForm->id =  $this->getStoreRecord()->form_id;
                $result = $this->getResultList($category_id, $sub_category_id, $sub_sub_sub_category_id, $label->id);
            }
            if ($result && $result['is_na'] == 1) {
                $result['label_point'] = 0;
                $label['bp'] = 0;
            }
            return [
                'id' => $label['id'],
                'name' => $label['name'],
                'bp' => $label['bp'],
                'points' => $result ? $result['label_point'] : 0,
                'result_id' => $result ? $result['id'] : 0,
                'is_all_nothing' => $label['is_all_nothing'],
                'remarks' => $result ? $result['label_remarks'] : null,
                'deviation' => $result ? $result['label_deviation'] : null,
                'is_na' => $result ? $result['is_na'] : 0,
                'dropdown' => $this->getDropdownList($label['dropdown_id'] ?? null) ?? null
            ];
        });
        return $sub_sub_sub_category;
    }
    public function getServiceResultList()
    {
        return ServiceSpeed::selectRaw(' SUM(assembly_points + tat_points + fst_points) AS total_points, SUM(base_assembly_points + base_tat_points + base_fst_points) AS base_total')->where('form_id', $this->auditForm->id)->first();
    }
    public function getResultList($category_id, $sub_category_id, $sub_sub_category_id, $label_id = null)
    {
        return AuditFormResult::where('form_id', $this->auditForm->id)
            ->where('category_id', $category_id)
            ->where('sub_category_id', $sub_category_id)
            ->where('sub_sub_category_id', $sub_sub_category_id)
            ->when($label_id != null, function ($query) use ($label_id) {
                $query->where('label_id', $label_id);
            })
            ->first();
    }
    public function getStoreRecord(){
        return AuditFormResult::where('form_id', $this->summary->form_id)->first();
    }
    public function getDeviationResultList($category_id, $deviation_id, $critical_deviation_id)
    {
        return CriticalDeviationResult::where('form_id', $this->auditForm->id)
            ->where('category_id', $category_id)
            ->where('deviation_id', $deviation_id)
            ->where('critical_deviation_id', $critical_deviation_id)
            ->first();
    }
    public function getTotalBp($subCategory)
    {
        if ($subCategory->is_sub == 0) {
            return $subCategory['sub_sub_category']->sum('bp');
        } else {
            return $subCategory['sub_sub_category']->flatMap(function ($subSubCategory) {
                return $subSubCategory['sub_sub_sub_category']->pluck('bp');
            })->sum();
        }
    }
    public function getTotalScore($is_sub, $subCategory)
    {
        if ($is_sub == 0) {
            return $subCategory->sum('points');
        } else {
            return $subCategory->flatMap(function ($item) {
                return $item['sub_sub_sub_category'];
            })->sum('points');
        }
    }
    public function getPercentage($category_id, $subCategory, $total_base, $total_score)
    {
        $percent = 100;
        switch ($subCategory->name) {
            case 'Ensaymada':
                $percent = 20;
                break;
            case 'Cheese roll':
                $percent = 20;
                break;
            case 'Espresso':
                $percent = 30;
                break;
            case 'Infused Water':
                $percent = 10;
                break;
            case 'Cake Display':
                $percent = 20;
                break;
        }
        if ($total_base == 0) {
            return 0;
        }
        $computeScore = $total_score / $total_base;
        $getPercent = $computeScore * $percent;
        return round(($getPercent), 0);
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
    public function getAuditResult($result_id)
    {
        return AuditFormResult::find($result_id);
    }
    public function getService(){
        return ServiceSpeed::where('form_id', $this->auditForm->id)->get();
    }
}