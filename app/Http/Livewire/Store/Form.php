<?php
namespace App\Http\Livewire\Store;

use Livewire\Component;
use App\Models\Category as CategoryModel;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
use App\Models\DropdownMenu as DropdownMenuModel;

class Form extends Component
{
    public $store_name;
    /* Audit Category */
    public $store_type = 1;
    public $active_tab;
    public $data;
    public $lslp = [];
    public $lcm = [
        [
            'sd' => 'SD1',
            'product' => 'EQ'
        ],
        [
            'sd' => 'SD3',
            'product' => 'CR'
        ],
    ];
    public function render()
    {
        $data = CategoryModel::select('id', 'name', 'type')
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
                                'remarks' => '',
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
        }
        return view('livewire.store.form', ['category_list' => $data])->extends('layouts.app');
    }
    public function mount($store_name = null)
    {
        $this->store_name = $store_name;

    }
}
