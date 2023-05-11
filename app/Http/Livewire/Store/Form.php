<?php
namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;
use App\Models\AuditForm as AuditFormModel;
use App\Models\AuditFormResult as AuditFormResultModel;

use Illuminate\Support\Facades\Auth;
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
        $this->audit_forms_id = AuditFormModel::where('store_id', $this->store_id)->value('id');
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
                        $isAllNothing = $label->is_all_nothing;
                        $total_bp += $label->bp;
                        $total_base_score += $label->bp;
                        return [
                            'id' => $label->id,
                            'name' => $label->name,
                            'bp' => $label->bp,
                            'is_all_nothing' => $isAllNothing,
                            'points' => $label->bp,
                            'remarks' => null,
                            'tag' => '',
                            'dropdown' => $dropdownMenu,
                        ];
                    }) : $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_base_score) {
                        $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                        $subLabelData = $subLabels->map(function ($subLabel) use (&$total_bp, &$total_base_score) {
                            $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                            $isAllNothing = $subLabel->is_all_nothing;
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
        dd($this->category_list);
        return view('livewire.store.form', ['sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }
    public function updateRemarks($id, $parentIndex, $subIndex, $childIndex, $categoryId, $subcategoryId, $labelId, $value)
    {
        $points = $this->category_list[$parentIndex]['sub_categ']['data_items'][$subIndex]['sub_category'][$childIndex]['points'];
        $is_all = $this->category_list[$parentIndex]['sub_categ']['data_items'][$subIndex]['sub_category'][$childIndex]['is_all_nothing'];
        $this->dispatchBrowserEvent('checkPoints', [
            'id' => $id,
            'value' => $value,
            'points' => $points,
            'is_all' => $is_all,
        ]);
        /* if ($is_all) {
        if ($value == $points || $value == 0) {
        dd($value);
        } else {
        $categoryListCollection = collect($this->category_list);
        $categoryListCollection[$parentIndex]['sub_categ']['data_items'][$subIndex]['sub_category'][$childIndex]['points'] = $value;
        $this->category_list = $categoryListCollection->toArray();
        }
        } else {
        dd($points);
        } */
        /* dd($parentIndex, $subIndex, $childIndex,$categoryId,$subcategoryId,$labelId, $value); */
        /* $category = $this->category_list[$parentIndex];
        $subCategory = $category->sub_categ['data_items'][$subIndex];
        $subCategory['sub_category'][$childIndex]['remarks'] = $value
        $category->sub_categ['data_items'][$subIndex] = $subCategory;
        $this->category_list[$parentIndex] = $category; */
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
    }
    public function onSaveResult()
    {
        $auditResults = collect($this->category_list)
            ->flatMap(function ($data) {
                return collect($data->sub_categ['data_items'])->flatMap(function ($sub) use ($data) {
                    return collect($sub['sub_category'])->map(function ($child) use ($data, $sub) {
                        return [
                            'form_id' => $this->audit_forms_id,
                            'category_id' => $data->id,
                            'category_name' => $data->name,

                            'sub_category_id' => $sub['id'],
                            'sub_name' => $sub['name'],
                            'sub_base_point' => $sub['bp']?? null,
                            'sub_point' => $sub['points']?? null,
                            'sub_remarks' => $sub['remarks']?? null,
                            'sub_file' => $sub['tag']?? null,

                            'sub_sub_category_id' => $child['id'],
                            'sub_sub_name' => $child['name'],
                            'sub_sub_base_point' => $child['bp'] ?? null,
                            'sub_sub_point' => $child['points']?? null,
                            'sub_sub_remarks' => $child['remarks']?? null,
                            'sub_sub_file' => $child['tag']?? null,
                        ];
                    });
                });
            });

        dd($auditResults);


        /* 'sub_base_point' => $sub['bp'],
        'sub_point' => $sub['points'],
        'sub_remarks' => $sub['remarks'],
        'sub_file' => $sub['tag'], */


        /*   AuditFormResultModel::create([
        'form_id' => $this->audit_forms_id,
        'category_id' => $this->data->id,
        'category_name' => $this->name,
        ]); */

    }
}
