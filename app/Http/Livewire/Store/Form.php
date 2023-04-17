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
            $sub_category = [
                [
                    'data_items' => $subCategories->map(function ($subCategory) {
                        $subCategoryData = [
                            'id' => $subCategory->id,
                            'is_sub' => $subCategory->is_sub,
                            'name' => $subCategory->name,
                            'overall_score' => '100%',
                            'score' => '20',
                            'total_percentage' => '100%',
                        ];
                        if ($subCategory->is_sub == 0) {
                            $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) {
                                $dropdownMenu = DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray();
                                $isAllNothing = $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*';

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
                            $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) {
                                $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                                $subLabelData = $subLabels->map(function ($subLabel) {
                                    $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                                    $isAllNothing = $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*';
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

                        return $subCategoryData;
                    }),
                    'overall_score' => '100%',
                    'score' => '91',
                    'total_percentage' => '100%',
                ]
            ];
            $category->sub_category = $sub_category;
        }
        return view('livewire.store.form', ['category_list' => $data])->extends('layouts.app');
    }
    public function mount($store_name = null)
    {
        $this->store_name = $store_name;
        $service_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
            },
        ])->where('category_id', 1)->get();
        $this->service = [
            [
                'data_items' => $service_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' => $subCategory->subCategoryLabels->map(function ($label) {
                                    return [
                                        'id' => $label->id,
                                        'name' => $label->name,
                                        'bp' => $label->bp,
                                        'is_all_nothing' => $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*',
                                        'points' => $label->bp,
                                        'remarks' => '',
                                        'tag' => '',
                                        'dropdown' => DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray()
                                    ];
                                })
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $subCategoryQuery = SubCategoryModel::query()
            ->where('category_id', 2)
            ->with([
                'subCategoryLabels' => function ($query) {
                    $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
                },
            ])
            ->get();
        $this->food = [
            [
                'data_items' => $subCategoryQuery->map(function ($subCategory) {
                    $subCategoryData = [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                    ];
                    if ($subCategory->is_sub == 0) {
                        $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) {
                            $dropdownMenu = DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray();
                            $isAllNothing = $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*';

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
                        $subCategoryData['sub_category'] = $subCategory->subCategoryLabels->map(function ($label) {
                            $subLabels = SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get();
                            $subLabelData = $subLabels->map(function ($subLabel) {
                                $dropdownMenu = DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray();
                                $isAllNothing = $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*';
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

                    return $subCategoryData;
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $production_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
            },
        ])->where('category_id', 3)->get();
        $this->production = [
            [
                'data_items' => $production_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
                        'name' => $subCategory->name,
                        'overall_score' => '100%',
                        'score' => '20',
                        'total_percentage' => '100%',
                        'sub_category' =>
                        ($subCategory->is_sub == 0 ?
                            $subCategory->subCategoryLabels->map(function ($label) {
                                        return [
                                            'id' => $label->id,
                                            'name' => $label->name,
                                            'bp' => $label->bp,
                                            'is_all_nothing' => $label->is_all_nothing == 0 ? $label->bp : $label->bp . '*',
                                            'points' => '',
                                            'remarks' => '',
                                            'tag' => '',
                                            'dropdown' => DropdownMenuModel::where('dropdown_id', $label->dropdown_id)->get()->toArray()
                                        ];
                                    }) :
                            $subCategory->subCategoryLabels->map(function ($label) {
                                        return [
                                            'id' => $label->id,
                                            'name' => $label->name,
                                            'label' => SubSubCategoryLabelModel::where('sub_sub_category_id', $label->id)->get()->map(function ($subLabel) {
                                                                        return [
                                                                            'id' => $subLabel->id,
                                                                            'name' => $subLabel->name,
                                                                            'bp' => $subLabel->bp,
                                                                            'is_all_nothing' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*',
                                                                            'points' => '',
                                                                            'remarks' => '',
                                                                            'tag' => '',
                                                                            'dropdown' => DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray()
                                                                        ];
                                                                    })
                                        ];
                                    }))
                    ];
                }),
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $clean_list = SubCategoryModel::with([
            'subCategoryLabels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
            },
        ])->where('category_id', 4)->get();
        $this->clean = [
            [
                'data_items' => $clean_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
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
                                                                    'bp' => $subLabel->bp,
                                                                    'is_all_nothing' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*',
                                                                    'points' => '',
                                                                    'remarks' => '',
                                                                    'tag' => '',
                                                                    'dropdown' => DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray()
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
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
            },
        ])->where('category_id', 5)->get();
        $this->document = [
            [
                'data_items' => $document_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
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
                                                                    'bp' => $subLabel->bp,
                                                                    'is_all_nothing' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*',
                                                                    'points' => '',
                                                                    'remarks' => '',
                                                                    'tag' => '',
                                                                    'dropdown' => DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray()
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
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id', 'dropdown_id');
            },
        ])->where('category_id', 6)->get();
        $this->people = [
            [
                'data_items' => $people_list->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'is_sub' => $subCategory->is_sub,
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
                                                                    'bp' => $subLabel->bp,
                                                                    'is_all_nothing' => $subLabel->is_all_nothing == 0 ? $subLabel->bp : $subLabel->bp . '*',
                                                                    'points' => '',
                                                                    'remarks' => '',
                                                                    'tag' => '',
                                                                    'dropdown' => DropdownMenuModel::where('dropdown_id', $subLabel->dropdown_id)->get()->toArray()
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
