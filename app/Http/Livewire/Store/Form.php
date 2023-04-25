<?php
namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Store as StoreModel;
use App\Models\Category as CategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;
use App\Models\SanitaryModel as SanitaryModel;
use App\Models\CriticalDeviationMenu as CriticalDeviationMenuModel;

class Form extends Component
{
    public $store_id;
    public $store_name;
    /* Audit Category */
    public $store_type;
    public $f_major_sd = [];
    public $f_product;
    public $sanitation_defect;
    public function mount($store_id = null)
    {
        $this->store_id = $store_id;
        $store = StoreModel::find($store_id);
        $this->store_name = $store->name;
        $this->store_type = $store->type;
    }
    public function render()
    {

        $sanitation_defect = SanitaryModel::select('id', 'title', 'code')->get();
        $data = CategoryModel::select('id', 'name', 'type', 'critical_deviation')
            ->where('type', $this->store_type)
            ->with([
                'subCategories' => function ($query) {
                    $query->with([
                        'subCategoryLabels' => function ($query) {
                                    $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
                                },
                    ]);
                }
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
                    if ($subCategory->is_sub == 0) {
                        $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_base_score) {
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
                        });
                    } else {
                        $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) use (&$total_bp, &$total_base_score) {
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
                    }
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
            } ?? []);
        }
        return view('livewire.store.form', ['category_list' => $data, 'sanitation_list' => $sanitation_defect])->extends('layouts.app');
    }
    public function onAddSd()
    {
        $sanitation = SanitaryModel::find($this->sanitation_defect);
        $newSd = [
            'id' => $sanitation->id,
            'code' => $sanitation->code,
            'title' => $sanitation->title,
            'remarks' => $this->f_product,
            'tag' => '',
        ];
        array_push($this->f_major_sd, $newSd);

    }

}
