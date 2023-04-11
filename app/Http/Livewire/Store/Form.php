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


        $food_list = SubCategoryModel::with([
            'labels' => function ($query) {
                $query->select('id', 'name', 'is_all_nothing', 'bp', 'sub_category_id');
            }
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
                        'sub_category' => $subCategory->labels->map(function ($label) {
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

        $production_list = SubCategoryModel::with([
            'labels' => function ($query) {
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
                        'sub_category' => $subCategory->labels->map(function ($label) {
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


        $this->service = [
            [
                'data_items' => [
                    [
                        'id' => '',
                        'name' => 'counter system',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Service Standards',
                                'label' => [
                                    ['name' => 'Personnel with personalized greetings/with welcome to the brand', 'bp' => '3*', 'points' => '3', 'remarks' => ''],
                                    ['name' => 'Counter crew suggests appropriately', 'bp' => '3', 'points' => '3', 'remarks' => ''],
                                    ['name' => 'Customer is informed of amount of bill/bill received & change', 'bp' => '3', 'points' => '3', 'remarks' => ''],
                                    ['name' => 'Change is given on the palm of the customer/receipt given directly to customer', 'bp' => '3', 'points' => '3', 'remarks' => ''],
                                    ['name' => 'Products are properly and neatly presented (3 eye system)', 'bp' => '3', 'points' => '3', 'remarks' => ''],
                                    ['name' => 'Coins and Bills availability', 'bp' => '3', 'points' => '3', 'remarks' => ''],
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => '2',
                        'name' => 'SERVICE SEQUENCE',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Service Standards',
                                'label' => [
                                    ['name' => 'With correct and appropriate crew positioning and manning Note: Tick box where deviation is noted', 'bp' => '5*', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Guest are seatted and handed the Menu', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Server with full attention during order-taking', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Temporary Receipt and Order List is placed on customer table', 'bp' => '3*', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Correct Utensils is set to customer table  placed in glassine or EQ plate', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Customer is updated on status of orders', 'bp' => '3*', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'There is a sequentialy delivery, assembly and dispatch of orders', 'bp' => '5*', 'points' => '', 'remarks' => 'sample remarks'],
                                    ['name' => 'There is a person assigned to support and ease speed', 'bp' => '3*', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Customer is updated on status of orders', 'bp' => '3*', 'points' => '3', 'remarks' => 'sample remarks'],

                                ]
                            ]
                        ],
                    ],
                    [
                        'id' => '3',
                        'name' => 'dining system',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'RAW MATERIALS W/ STANDARD QUALITY',
                                'label' => [
                                    ['name' => 'Proper handling of received stocks', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Raw Material w/ Standard Quality', 'bp' => '3', 'points' => '', 'remarks' => 'sample remarks'],
                                ]
                            ],
                            [
                                'name' => 'CORRECT RECEIVING & HANDLING PROCEDURES',
                                'label' => [
                                    ['name' => 'Proper storage of Raw Materials', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                ],
                            ]
                        ],
                    ],
                    [
                        'id' => '4',
                        'name' => 'customer service',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'CAKE SLICING',
                                'label' => [
                                    ['name' => 'KNOWLEDGE AND PROPER USE OF T&U', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'CORRECT SLICING (SIZE AND PROPORTION)', 'bp' => '3', 'points' => '', 'remarks' => 'sample remarks'],
                                ]
                            ],
                            [
                                'name' => 'PRE-PREPARATION',
                                'label' => [
                                    ['name' => 'Correct Beans in use', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Correct Milk', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],

                                ],
                            ],
                            [
                                'name' => 'BREWING',
                                'label' => [
                                    ['name' => 'PROPER GRIND DISTRIBUTION IS DONE', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'CORRECT TAMPING IS DONE', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],

                                ],
                            ],
                            [
                                'name' => 'STEAMING',
                                'label' => [
                                    ['name' => 'MILK', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'CAKE and PASTRY', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],

                                ],
                            ]
                        ],
                    ],
                    [
                        'id' => '',
                        'name' => 'people image',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'PREPARATION',
                                'label' => [
                                    ['name' => 'Standard and correct tools', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Raw Material w/ Standard Quality', 'bp' => '3', 'points' => '', 'remarks' => 'sample remarks'],
                                ]
                            ],
                            [
                                'name' => 'COOKING',
                                'label' => [
                                    ['name' => 'Cooking Time', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                ],
                            ]
                        ],
                    ]
                ],
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $this->document = [
            [
                'data_items' => [
                    [
                        'id' => '',
                        'name' => 'primary system',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Food',
                                'label' => [
                                    ['name' => 'People Training Calendar (Product Knowledge)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Product Traceability (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Shelflife Monitoring (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Equipment Checklist (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                ],
                            ],
                            [
                                'name' => 'Service',
                                'label' => [
                                    ['name' => 'People Training Calendar (Product Knowledge)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Product Traceability (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Shelflife Monitoring (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Equipment Checklist (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                ],
                            ],
                            [
                                'name' => 'Ambiance',
                                'label' => [
                                    ['name' => 'People Training Calendar (Product Knowledge)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Product Traceability (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Shelflife Monitoring (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                    ['name' => 'Equipment Checklist (MT Workbook)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => '2',
                        'name' => 'support system',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Food Safety',
                                'label' => [
                                    ['name' => 'With correct and appropriate crew positioning and manning Note: Tick box where deviation is noted', 'bp' => '5*', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Guest are seatted and handed the Menu', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Server with full attention during order-taking', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                ]
                            ],
                            [
                                'name' => 'Inventory Management',
                                'label' => [
                                    ['name' => 'With correct and appropriate crew positioning and manning Note: Tick box where deviation is noted', 'bp' => '5*', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Guest are seatted and handed the Menu', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Server with full attention during order-taking', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                ]
                            ]
                        ],
                    ],
                    [
                        'id' => '3',
                        'name' => 'Strategic System ',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Approved Manpower',
                                'label' => [
                                    ['name' => 'Proper handling of received stocks', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                ]
                            ],
                            [
                                'name' => 'Sales Analysis',
                                'label' => [
                                    ['name' => 'Proper storage of Raw Materials', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                ],
                            ]
                        ],
                    ],
                    [
                        'id' => '4',
                        'name' => 'Management System',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'BIR Report',
                                'label' => [
                                    ['name' => 'KNOWLEDGE AND PROPER USE OF T&U', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'CORRECT SLICING (SIZE AND PROPORTION)', 'bp' => '3', 'points' => '', 'remarks' => 'sample remarks'],
                                ]
                            ],
                            [
                                'name' => 'Permit and LIcenses',
                                'label' => [
                                    ['name' => 'Correct Beans in use', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Correct Milk', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],

                                ],
                            ]
                        ],
                    ]
                ],
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $this->people = [
            [
                'data_items' => [
                    [
                        'id' => '',
                        'name' => 'Manpower Completion',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => '',
                                'label' => [
                                    ['name' => 'People Training Calendar (Product Knowledge)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => '2',
                        'name' => 'Manpower Competence, Behavior and Mannersv',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => '',
                                'label' => [
                                    ['name' => 'With correct and appropriate crew positioning and manning Note: Tick box where deviation is noted', 'bp' => '5*', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Guest are seatted and handed the Menu', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Server with full attention during order-taking', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                ]
                            ]
                        ],
                    ],
                    [
                        'id' => '3',
                        'name' => 'Compliance to Regulatory Law ',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => 'Store is a safe workplace',
                                'label' => [
                                    ['name' => 'Proper handling of received stocks', 'bp' => '3', 'points' => '', 'remarks' => 'remarks'],
                                ]
                            ],
                            [
                                'name' => 'Store is compliant to government regulations',
                                'label' => [
                                    ['name' => 'Proper storage of Raw Materials', 'bp' => '', 'points' => '', 'remarks' => 'remarks'],
                                ],
                            ]
                        ],
                    ]
                ],
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];
        $this->clean = [
            [
                'data_items' => [
                    [
                        'id' => '',
                        'name' => 'Costumer Area',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => '',
                                'label' => [
                                    ['name' => 'People Training Calendar (Product Knowledge)', 'bp' => '', 'points' => '', 'remarks' => ''],
                                ],
                            ]
                        ]
                    ],
                    [
                        'id' => '2',
                        'name' => 'Non-customer area',
                        'total_percentage' => '20%',
                        'score' => '0',
                        'sub_category' => [
                            [
                                'name' => '',
                                'label' => [
                                    ['name' => 'With correct and appropriate crew positioning and manning Note: Tick box where deviation is noted', 'bp' => '5*', 'points' => '', 'remarks' => 'remarks'],
                                    ['name' => 'Guest are seatted and handed the Menu', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                    ['name' => 'Server with full attention during order-taking', 'bp' => '3', 'points' => '3', 'remarks' => 'sample remarks'],
                                ]
                            ]
                        ],
                    ]
                ],
                'overall_score' => '100%',
                'score' => '91',
                'total_percentage' => '100%',
            ]
        ];


    }

}
