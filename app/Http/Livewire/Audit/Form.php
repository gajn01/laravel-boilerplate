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
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\CriticalDeviationResult as CriticalDeviationResultModel;

use App\Models\ServiceSpeed as ServiceSpeedModel;
use DateTime;
use DateTimeZone;

class Form extends Component
{
    protected $listeners = ['start-alert-sent' => 'onUpdateStatus'];
    private $timezone, $time, $date_today;
    public $active_index = 0;
    public AuditForm $auditForm;
    public AuditDate $auditDate;
    public Store $store;
    public Summary $summary;
    public function __construct()
    {
        $this->timezone = new DateTimeZone('Asia/Manila');
        $this->time = new DateTime('now', $this->timezone);
        $this->date_today = $this->time->format('Y-m-d');
        $this->initialize();
    }
    public function mount($id = null)
    {
        $this->store = Store::find($id);
    }
    public function render()
    {
        $data= $this->mapCategory();
        $this->auditDate = AuditDate::where('store_id', $this->store->id)->where('audit_date', $this->date_today)->first();
        return view('livewire.audit.form',['categoryList'=>$data])->extends('layouts.app');
    }
    public function mapCategory(){
        $data = $this->getCategoryList();
        foreach ($data as $category) {
            $category_id = $category->id;
            $total_bp = 0;
            $total_base = 0;
            $total_score = 0;
            $saved_critical_score = 0;
            $sub_category = $category->sub_category->transform(function ($subCategory) use ($category_id) {
                    $sub_category_id = $subCategory->id;
                    $subCategoryData = [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'base_score' => 0,
                        'total_point' => 0,
                        'total_percent' => 0,
                    ];
                    $subCategoryData['sub_sub_category'] = $this->getSubSubCategory($subCategory,$category_id, $sub_category_id);

                return $subCategoryData;
            });
            $category->sub_category = $sub_category;
        }
        return $data;
    }
    public function getSubSubCategory($subCategory,$category_id, $sub_category_id) {
        $is_sub = $subCategory->is_sub;
        $subCategory->sub_sub_category->transform(function ($label) use ($is_sub,$category_id,$sub_category_id) {
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
            if($is_sub == 0){
                $data['is_all_nothing'] = $label->is_all_nothing;
                $data['remarks'] = $result ? $result['sub_sub_remarks'] : null;
                $data['deviation'] = $result ? $result['sub_sub_deviation'] : null;
                $data['is_na'] = $result['is_na'] ?? 0;
                $data['dropdown'] = $this->getDropdownList($label->dropdown_id) ?? null;
            }else{
                $data['sub_sub_sub_category']=$this->getSubSubSubCategory($label->sub_sub_sub_category);
            }
            return $data;

        });
        return $subCategory->sub_sub_category;
    }
    public function getSubSubSubCategory($sub_sub_sub_category,$category_id = null, $sub_category_id = null, $sub_sub_sub_category_id = null){

        $sub_sub_sub_category->transform(function ($label) use ($category_id, $sub_category_id,$sub_sub_sub_category_id) {
            if($this->store->audit_status){
               $result =  $this->getResult($category_id,$sub_category_id,$sub_sub_sub_category_id);
            }
            return [
                'id' => $label->id,
                'name' => $label->name,
                'bp' => $label->bp,
                'points' => $result ? $result['label_point'] : 0,
                'is_all_nothing' => $label->is_all_nothing,
                'remarks' => $result ? $result['label_remarks'] : null,
                'deviation' => $result ? $result['label_deviation'] : null,
                'na' =>  $result['is_na'] ?? 0,
                'dropdown' => $this->getDropdownList($label->dropdown_id) ?? null
            ];
        });
        return $sub_sub_sub_category;
    }
    public function getResult($category_id,$sub_category_id,$label_id){
        $this->auditForm = AuditForm::where('store_id',$this->store->id)->where('date_of_visit',$this->date_today)->first();
            $result = AuditFormResult::where('form_id', $this->auditForm->id)
                ->where('category_id', $category_id)
                ->where('sub_category_id', $sub_category_id)
                ->where('sub_sub_category_id', $label_id)
                ->first();
            return $result;
    }
    public function getDeviationList(){

    }
    public function getDropdownList($id){
       return DropdownMenuModel::where('dropdown_id', $id)->get()->toArray();
    }
    public function getCategoryList(){
        return Category::where('type', $this->store->type)
        ->orderBy('type', 'DESC')
        ->orderBy('order', 'ASC')
        ->get();
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