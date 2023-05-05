<?php
namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Helpers\CustomHelper;
use DateTime;
use DateTimeZone;

class Form extends Component
{
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
    public $actionTitle = 'Start';
    public $currentField;
    public $currentIndex;
    public $cashier_tat = [['name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'ot_point' => 1, 'tat' => null, 'tat_point' => 1, 'fst' => null, 'fst_point' => 3, 'remarks' => null]];
    public $server_cat = [['name' => null, 'time' => null, 'product_order' => null, 'ot' => null, 'ot_point' => 1, 'tat' => null, 'tat_point' => 1, 'fst' => null, 'fst_point' => 3, 'remarks' => null]];
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
    public function render()
    {
        $store = StoreModel::find($this->store_id);
        $this->store_name = $store->name;
        $this->store_type = $store->type;
        $this->audit_status = $store->audit_status;
        $this->actionTitle = $this->audit_status ? 'Complete' : 'Start';
        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();
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
            $total_bp = 0;
            $total_base_score = 0;
            $sub_category = [
                'data_items' => $subCategories->map(function ($subCategory) use (&$total_bp, &$total_base_score) {
                    $subCategoryData = [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'base_score' => 0,
                        'total_percent' => 0,
                    ];
                    $subCategoryData['sub_category'] = ($subCategory->is_sub == 0) ? $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_base_score) {
                            $dropdownMenu = DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray();
                            $isAllNothing = $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*';
                            $total_bp += $label->bp;
                            $total_base_score += $label->bp;
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'bp' => $label->bp,
                                'is_all_nothing' => $isAllNothing,
                                'points' => $label->bp,
                                'remarks' => 'fs',
                                'tag' => '',
                                'dropdown' => $dropdownMenu,
                            ];
                        }) : $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_base_score) {
                            $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                            $subLabelData = $subLabels->map(function ($subLabel) use (&$total_bp, &$total_base_score) {
                                $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                                $isAllNothing = $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*';
                                $total_bp += $subLabel->bp;
                                $total_base_score += $subLabel->bp;
                                return [
                                    'id' => $subLabel->id,
                                    'name' => $subLabel->name,
                                    'bp' => $subLabel->bp,
                                    'is_all_nothing' => $isAllNothing,
                                    'points' => $subLabel->bp,
                                    'remarks' => '',
                                    'tag' => '',
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
                    $subCategoryData['total_percent'] = $total_bp * 100 / $total_bp;
                    $total_bp = 0;
                    return $subCategoryData;
                }),
                'total_base_score' => $total_base_score,
                'total_percentage' => '100',
            ];
            $category->sub_categ = $sub_category;
            $critical_deviation = CriticalDeviationMenuModel::select('*')
                ->where('critical_deviation_id', $category->critical_deviation)
                ->get();
            $category->critical_deviation = $critical_deviation->map(function ($cd) {
                $dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->dropdown_id)->get()->toArray();
                $location_dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->location_dropdown_id)->get()->toArray();
                $product_dropdownMenu = DropdownMenuModel::where('dropdown_id', $cd->product_dropdown_id)->get()->toArray();
                return [
                    'id' => $cd->id,
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
                ];
            });
        }
        $this->category_list = $data;
        return view('livewire.store.form', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
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
    public function test()
    {
        dd($this->category_list);
    }
    public function onStartAndComplete($is_confirm = true, $title = 'Are you sure?', $type = null, $data = null)
    {
        $data = $this->store_id;
        if ($this->audit_status) {
            $message = 'Are you sure you want to complete this audit?';
        } else {
            $message = 'Are you sure you want to start this audit?';
        }
        $this->emit('onStartAlert', $message);
    }
    public function onUpdateStatus()
    {
        $data = $this->audit_status ? false : true;
        StoreModel::where('id', $this->store_id)->update([
            'audit_status' => $data,
        ]);
    }
}
