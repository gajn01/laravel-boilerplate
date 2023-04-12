<?php
namespace App\Http\Livewire\Store;
use Livewire\Component;
use App\Models\SubCategory as SubCategoryModel;
use App\Models\SubSubCategoryLabel as SubSubCategoryLabelModel;
class Form extends Component
{
    public $store_name;
    /* Audit Category */
    public $food = [];
    public $data;

    public $production = [];
    public $service = [];
    public $clean = [];
    public $document = [];
    public $people = [];
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

    public function addLcm()
    {
        dd($this->food);
    }
    public function render()
    {
        return view('livewire.store.form')->extends('layouts.app');
    }
    public function mount($store_name = null)
    {
        $this->store_name = $store_name;
        $service_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
        ])->where('category_id', 1)->get();
        $this->service = [
            [
                'data_items' => $service_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'bp' => $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*',
                                'points' => '',
                                'remarks' => '',
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $food_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
            'category',
        ])->where('category_id', 2)->get();
        $this->food = [
            [
                'data_items' => $food_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'bp' => $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*',
                                'points' => '',
                                'remarks' => '',
                                'tag' => '',
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $production_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
        ])->where('category_id', 3)->get();
        $this->production = [
            [
                'data_items' => $production_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'label' => SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get()->map(function ($subLabel) {
                                    return [
                                        'id' => $subLabel->id,
                                        'name' => $subLabel->name,
                                        'bp' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp.'*',
                                        'points' => '',
                                        'remarks' => '',
                                    ];
                                })
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $clean_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
        ])->where('category_id', 4)->get();
        $this->clean = [
            [
                'data_items' => $clean_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'label' => SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get()->map(function ($subLabel) {
                                    return [
                                        'id' => $subLabel->id,
                                        'name' => $subLabel->name,
                                        'bp' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp.'*',
                                        'points' => '',
                                        'remarks' => '',
                                    ];
                                })
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $document_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
        ])->where('category_id', 5)->get();
        $this->document = [
            [
                'data_items' => $document_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'label' => SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get()->map(function ($subLabel) {
                                    return [
                                        'id' => $subLabel->id,
                                        'name' => $subLabel->name,
                                        'bp' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp.'*',
                                        'points' => '',
                                        'remarks' => '',
                                    ];
                                })
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $people_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            },
        ])->where('category_id', 6)->get();
        $this->people = [
            [
                'data_items' => $people_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                            return [
                                'id' => $label->id,
                                'name' => $label->name,
                                'label' => SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get()->map(function ($subLabel) {
                                    return [
                                        'id' => $subLabel->id,
                                        'name' => $subLabel->name,
                                        'bp' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp.'*',
                                        'points' => '',
                                        'remarks' => '',
                                    ];
                                })
                            ];
                        })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
    }
}
