<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CustomHelper;
/* models  */
use App\Models\Store;
use App\Models\AuditForm;
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

class Form extends Component
{
    protected $listeners = ['start-alert-sent' => 'onUpdateStatus'];
    private $timezone, $time, $date_today;
    public $active_index = 0;
    public $sanitary_list;
    public $cashier_tat,$server_cat;
    public AuditForm $auditForm;
    public Store $store;
    public Summary $summary;
    public AuditFormResult $auditResult;
    public ServiceSpeed $serviceSpeed;
    public CriticalDeviationResult $criticalDeviationResult;
    public $score = [['name' => '3'],['name' => '5'],['name' => '10'],['name' => '15']];
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->initialize();
    }
    public function mount($id = null)
    {
        $this->auditForm = AuditForm::find($id);
        $this->sanitary_list = SanitaryModel::get();
        $this->store = Store::find($this->auditForm->store_id);

    }
    public function render()
    {
        if($this->auditForm->audit_status){
            $this->summary = Summary::where('form_id', $this->auditForm->id)->first();
        }
        $service = $this->getService();
        $this->cashier_tat = $service->where('is_cashier', 1);
        $this->server_cat = $service->where('is_cashier', 0);
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
    #region intialization
    public function initialize()
    {
        $this->store = new Store;
        $this->auditForm = new AuditForm;
        $this->summary = new Summary;
        $this->auditResult = new AuditFormResult;
        $this->serviceSpeed = new ServiceSpeed;
    }
    #endregion
    #region service , speed and accuracy
    public function getService(){
        return ServiceSpeed::where('form_id', $this->auditForm->id)->get();
    }
    public function addService($id = null){
        $data = ['form_id' => $this->auditForm->id, 'is_cashier' => $id, 'name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'base_assembly_points' => 1, 'assembly_points' => 1, 'tat' => null, 'base_tat_points' => 1, 'tat_points' => 1, 'fst' => null, 'base_fst_points' => $id ? 3 : 5, 'fst_points' => $id ? 3 : 5,'att' => null,'base_att_points' => $id ? 0 : 1 , 'att_points' => $id ? 0 : 1 ,'remarks' => null, 'serving_time' => '5'];
        ServiceSpeed::create($data);
    }
    public function removeService($id){
        ServiceSpeed::find($id)->delete();
    }
    public function updateService($data, $key, $value)
    {
        $this->serviceSpeed = ServiceSpeed::find($data['id']);
        if(isset($data['base_' . $key])){
            $column = 'base_' . $key;
            if($value >= 0){
                $newValue = $value <= $this->serviceSpeed->$column ? $value : $this->serviceSpeed->$column ;
                $this->serviceSpeed->$key = $newValue;
                $this->serviceSpeed->save();
            }
        }else{
            $this->serviceSpeed->$key = $value;
            $this->serviceSpeed->save();
        }
    }
    #endregion
    #region Update Deviation
    public function updateCriticalDeviation($category,$audit_form_id,$data,$value,$key){
        $this->criticalDeviationResult = criticalDeviationResult::where('category_id',$category['id'])->where('form_id',$audit_form_id)->where('deviation_id',$data['id'])->first();
        $this->criticalDeviationResult->$key = $value;
        $this->criticalDeviationResult->save();
    }
    #endregion
    #region Update Audit Score
    public function updateNA($data,$value){
        $this->auditResult = $this->getAuditResult($data['result_id']);
        $this->auditResult->is_na = $value;
        $this->auditResult->save();
    }
    public function updatePoints($is_sub, $data, $value)
    {
        $validated_points = max(0, min($value, $data['bp']));
        $this->auditResult = $this->getAuditResult($data['result_id']);
        $this->auditResult->{($is_sub == 0) ? 'sub_sub_point' : 'label_point'} = $validated_points;
        $this->auditResult->save();
    }
    public function updateRemarks($is_sub,$result_id,$value){
        $this->auditResult = $this->getAuditResult($result_id);
        $this->auditResult->{($is_sub == 0) ? 'sub_sub_remarks' : 'label_remarks'} = $value;
        $this->auditResult->save();
    }
    public function updateDeviation($is_sub,$result_id,$value){
        $this->auditResult = $this->getAuditResult($result_id);
        $this->auditResult->{($is_sub == 0) ? 'sub_sub_deviation' : 'label_deviation'} = $value;
        $this->auditResult->save();
    }
    public function getAuditResult($result_id){
        return AuditFormResult::find($result_id);
    }
    #endregion
    #region Set up Audit Forms
    public function mapCategory()
    {
        $data = $this->getCategoryList();
        foreach ($data as $category) {
            $category_id = $category->id;
            $total_base = 0;
            $total_points = 0;
            $total_percent = 0;
            $category->sub_category->transform(function ($subCategory) use ($category,$category_id, &$total_base, &$total_points,&$total_percent) {
                $sub_category_id = $subCategory->id;
                $subCategory->points = 0;
                $sub_sub_category = $this->getSubSubCategory($subCategory, $category_id, $sub_category_id);
                $total_base += $this->getTotalBp($subCategory);
                $total_points += $this->getTotalScore($subCategory['is_sub'], $sub_sub_category);
                if($subCategory['name'] ==  "Speed and Accuracy"){
                    $total_base_per_category = $this->getServiceResultList()->base_total;
                    $total_points_per_category = $this->getServiceResultList()->total_points;
                    $total_base += $total_base_per_category;
                    $total_points += $total_points_per_category;
                    $total_percentage_per_category =  $this->getPercentage($category_id, $subCategory, $total_base_per_category, $total_points_per_category);
                }else{
                    $total_base_per_category =$this->getTotalBp($subCategory);
                    $total_points_per_category = $this->getTotalScore($subCategory['is_sub'], $sub_sub_category);
                    $total_percentage_per_category =  $this->getPercentage($category_id, $subCategory, $this->getTotalBp($subCategory), $this->getTotalScore($subCategory['is_sub'], $sub_sub_category));
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
            $category->critical_deviation = $this->mapDeviation($category_id, $category->critical_deviation_id);

        }
        return $data;
    }
    public function mapDeviation($category_id, $critical_deviation_id)
    {
        $result = null;
        return $this->getDeviationList($critical_deviation_id)->transform(function ($deviation) use ($category_id, $critical_deviation_id,$result) {
            if ($this->store->audit_status) {
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
                'saved_sd' => $result ? $result['sd'] : 0,
                'saved_remarks' => $result ? $result['remarks'] : 0,
                'saved_score' => $result ? $result['score'] : 0,
                'saved_location' => $result ? $result['location'] : 0,
                'saved_product' => $result ? $result['product'] : 0,
                'saved_dropdown' => $result ? $result['dropdown'] : 0,
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
                if ($is_sub == 0 && $result && $result['is_na'] == 1) {
                    $result['sub_sub_point'] = 0;
                    $label['bp'] = 0;
                }
            }
            $data = [
                'id' => $label['id'],
                'name' => $label['name'],
                'bp' => $label['bp'],
                'points' => $result ? $result['sub_sub_point'] : $label['bp'],
                'result_id' =>$result ? $result['id'] : 0,
            ];
            if ($is_sub == 0) {
                $data['is_all_nothing'] = $label['is_all_nothing'];
                $data['remarks'] = $result ? $result['sub_sub_remarks'] : null;
                $data['deviation'] = $result ? $result['sub_sub_deviation'] : null;
                $data['is_na'] = $result ? $result['is_na'] : 0 ;
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
        $sub_sub_sub_category->transform(function ($label) use ($category_id, $sub_category_id, $sub_sub_sub_category_id,$result) {
            if ($this->store->audit_status) {
                $result = $this->getResultList($category_id, $sub_category_id, $sub_sub_sub_category_id,$label->id);
                if ($result && $result['is_na'] == 1) {
                    $result['label_point'] = 0;
                    $label['bp'] = 0;
                }
            }
            return [
                'id' => $label['id'],
                'name' => $label['name'],
                'bp' => $label['bp'],
                'points' => $result ? $result['label_point'] : $label['bp'],
                'result_id' =>$result ? $result['id'] : 0,
                'is_all_nothing' => $label['is_all_nothing'],
                'remarks' => $result ? $result['label_remarks'] : null,
                'deviation' => $result ? $result['label_deviation'] : null,
                'is_na' => $result ?  $result['is_na'] :0 ,
                'dropdown' => $this->getDropdownList($label['dropdown_id'] ?? null) ?? null
            ];
        });
        return $sub_sub_sub_category;
    }
    public function getServiceResultList(){
       return ServiceSpeed::selectRaw(' SUM(assembly_points + tat_points + fst_points + att_points) AS total_points, SUM(base_assembly_points + base_tat_points + base_fst_points + base_att_points) AS base_total')->where('form_id', $this->auditForm->id)->first();
    }
    public function getResultList($category_id, $sub_category_id, $sub_sub_category_id,$label_id = null)
    {
        $this->auditForm = AuditForm::where('store_id', $this->store->id)->where('date_of_visit', $this->date_today)->first();
        return AuditFormResult::where('form_id', $this->auditForm->id)
            ->where('category_id', $category_id)
            ->where('sub_category_id', $sub_category_id)
            ->where('sub_sub_category_id', $sub_sub_category_id)
            ->when($label_id != null ,function ($query) use ($label_id){
                $query->where('label_id', $label_id);
            })
            ->first();
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
        if($total_base == 0){
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
    #region Update Audit form,date,summary
    public function onUpdateStatus()
    {
        $this->updateStatus();
        $this->updateOrCreateSummary();
        $this->onInitialSave();
        $this->auditForm = AuditForm::where('store_id', $this->store->id)->where('date_of_visit', $this->date_today)->first();
        $this->summary = Summary::where('form_id', $this->auditForm->id)->where('store_id', $this->store->id) ->where('date_of_visit', $this->date_today)->first();
    }
    private function updateStatus()
    {
        $this->store->audit_status = 1;
        $this->store->save();
        $this->auditForm->audit_status = 1;
        $this->auditForm->save();
    }
    public function updateOrCreateSummary()
    {
        $this->summary = Summary::updateOrCreate(
            [
                'form_id' => $this->auditForm->id,
                'store_id' => $this->store->id,
            ],
            [
                'name' => $this->store->name,
                'code' => $this->store->code,
                'type' => $this->store->type,
                'wave' => $this->auditForm->wave,
                'conducted_by' => Auth::user()->name,
                'received_by' => null,
                'time_of_audit' => $this->time->format('h:i'),
            ]
        );
    }
    public function onInitialSave(){
        $auditResults = collect($this->mapCategory())->flatMap(function ($data) {
            return collect($data->sub_category)->flatMap(function ($sub) use ($data) {
                return collect($sub['sub_sub_category'])->map(function ($child) use ($data, $sub) {
                    $result = [
                        'form_id' => $this->auditForm->id,
                        'category_id' => $data->id,
                        'category_name' => $data->name,
                        'sub_category_id' => $sub['id'],
                        'sub_name' => $sub['name'],
                        'sub_sub_category_id' => $child['id'],
                        'sub_sub_name' => $child['name'],
                        'sub_sub_base_point' => $child['bp'] ?? null,
                        'sub_sub_point' => $child['bp'] ?? null,
                        'sub_sub_remarks' =>  null,
                        'sub_sub_deviation' =>  null,
                        'sub_sub_file' => $child['tag'] ?? null,
                        'is_na' => '0'
                    ];
                    if (isset($child['sub_sub_sub_category'])) {
                        return collect($child['sub_sub_sub_category'])->map(function ($label) use ($result) {
                            return array_merge($result, [
                                'label_id' => $label['id'],
                                'label_name' => $label['name'],
                                'label_base_point' => $label['bp'] ?? null,
                                'label_point' => $label['bp'] ?? null,
                                'label_remarks' =>  null,
                                'label_deviation' =>  null,
                                'label_file' =>  null,
                            ]);
                        });
                    } else {
                        return [$result];
                    }
                });
            });
        })->flatten(1);
        $critical_deviation = collect($this->mapCategory())->flatMap(function ($data) {
            $deviations = CriticalDeviationMenu::where('critical_deviation_id', $data->critical_deviation_id)->get();
            return collect($deviations)->map(function ($dev) use ($data) {
                $result = [
                    'form_id' => $this->auditForm->id,
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
                CriticalDeviationResult::updateOrCreate($result);
            }
        });
        $auditResults->each(function ($result) {
            if (is_array($result)) {
                AuditFormResult::updateOrCreate($result);
            }
        });
    }
    #endregion
    public function onAlert($is_confirm = false, $title = null, $message = null, $type = null, $data = null)
    {
        CustomHelper::onShow($this, $is_confirm, $title, $message, $type, $data);
    }
}