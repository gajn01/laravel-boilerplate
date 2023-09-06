<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use App\Models\AuditForm as AuditFormModel;
use App\Models\Store;
use App\Models\SanitaryModel;
use App\Models\StoreRecord;
use App\Models\AuditTemplate;

class AuditForm extends Component
{
    public $auditForm;
    public $store;
    public $active_index = 0;
    public $sanitary_list;
    public $form = [
        [
            'category' => 'Food',
            'total-base' => 94,
            'total-points' => 0,
            'percent' => 0,
            'sub-category' => [
                [
                    'title' => 'Ensaymada',
                    'total-base' => 15,
                    'total-points' => 0,
                    'percent' => 20,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Apperance / No SD',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Deformed'],
                                ['title' => 'Burnt'],
                                ['title' => 'Pale'],
                                ['title' => 'With SD'],
                            ]
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Texture',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Flasky'],
                                ['title' => 'Dry'],
                            ],
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Taste / Mouthfeel',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Bitter'],
                                ['title' => 'Sour'],
                                ['title' => 'Burning'],
                            ],
                        ]
                    ]
                ],
                [
                    'title' => 'Cheese Roll',
                    'total-base' => 15,
                    'total-points' => 0,
                    'percent' => 20,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Apperance / No SD',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Deformed'],
                                ['title' => 'Burnt'],
                                ['title' => 'Pale'],
                                ['title' => 'With SD'],
                            ]
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Texture',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Flasky'],
                                ['title' => 'Dry'],
                            ],
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Taste / Mouthfeel',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Bitter'],
                                ['title' => 'Sour'],
                                ['title' => 'Burning'],
                            ],
                        ]
                    ]
                ],
                [
                    'title' => 'Espresso',
                    'total-base' => 14,
                    'total-points' => 0,
                    'percent' => 30,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Serving Temperature',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Below 56C'],
                                ['title' => 'Above 60C'],
                            ]
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Appearance/ Portioning/ No SD',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Overportioned'],
                                ['title' => 'Underportioned'],
                                ['title' => 'With SD'],
                                ['title' => 'Defective Utensils'],
                            ],
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Creama Foam',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Dark'],
                                ['title' => 'Light'],
                                ['title' => 'Thin'],
                                ['title' => 'Sour'],
                            ],
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Taste',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => [
                                ['title' => 'Think'],
                                ['title' => 'Bitter'],
                                ['title' => 'Bland'],
                            ],
                        ]
                    ]
                ],
                [
                    'title' => 'Infused Water',
                    'total-base' => 10,
                    'total-points' => 0,
                    'percent' => 10,
                    'deviation' => [
                        [
                            'id' => 1,
                            'is-na' => 1,
                            'title' => 'Apperance / No SD',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'id' => 2,
                            'is-na' => 1,
                            'title' => 'Taste',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ],
                [
                    'title' => 'Cake Display',
                    'total-base' => 40,
                    'total-points' => 40,
                    'percent' => 20,
                    'deviation' => [
                        [
                            'title' => 'Whole',
                            'total-base' => 25,
                            'total-points' => 25,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'EQ',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'PU',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'MM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'FG',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'LMS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'AP',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CH',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'VT',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'SSCV',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CK',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'SW',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'LI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'MB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BA',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TAS/SS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'DCC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TLC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BCFP',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]

                            ]
                        ],
                        [
                            'title' => 'Mini',
                            'total-base' => 15,
                            'total-points' => 15,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'PU',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'LMS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'AP',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CH',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'VT',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'SSCV',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CK',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'SW',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'CC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'LI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'MB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'TAS/SS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                    ]
                ],
            ],
            'critical-deviation' =>[
                [
                    'title'=> 'Critical & Major SD',
                    'is-sd' => 1,
                    'is-location' => [
                        ['title' => 'Food'],
                        ['title' => 'Packaging'],
                        ['title' => 'Equipment'],
                        ['title' => 'Dining Area'],
                        ['title' => 'Other Rooms']
                    ],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
                [
                    'title'=> 'Spoiled/Lapsed product',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [
                        ['title' => 'Baked Goods'],
                        ['title' => 'Salad'],
                        ['title' => 'Appetizer'],
                        ['title' => 'Pasta'],
                        ['title' => 'Pizza'],
                        ['title' => 'Rice Meal'],
                        ['title' => 'Sandwich'],
                        ['title' => 'Mains'],
                        ['title' => 'Drinks'],
                    ],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'product' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ]
            ]
        ],
        [
            'category' => 'Production Process',
            'total-base' => 213,
            'total-points' => 213,
            'percent' => 100,
            'sub-category' => [
                [
                    'title' => 'TOOL & UTENSILS',
                    'total-base' => 39,
                    'total-points' => 39,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Weighing Scale',
                            'total-base' => 5,
                            'total-points' => 5,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Digital Weighing Scale',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ]
                            ]
                        ],
                        [
                            'title' => 'Portioning and Other Production Tools',
                            'total-base' => 34,
                            'total-points' => 34,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Measuring Cup',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tamping Mat',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Porta Filter',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Steaming Pitcher',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Thermometer',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Distributor',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tamper',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Knock Box',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bucket and Stand',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Wine Service Cloth',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cake Shovel',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Serrated Knife',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Chef`s Knife',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Food Grade Plastic Pitcher',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Acetate',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ]
                            ]
                        ]
                    ],
                ],
                [
                    'title' => 'Equipment',
                    'total-base' => 46,
                    'total-points' => 46,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Major Holding Equipment',
                            'total-base' => 21,
                            'total-points' => 21,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Standing Display Freezer',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Standing Display Chiller',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Combi Display',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Combi Back up',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar Chiller',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Back Up Freezer',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Wine Chiller',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Back Up Chiller',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ]
                            ]
                        ],
                        [
                            'title' => 'Major Equipment',
                            'total-base' => 25,
                            'total-points' => 25,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Espresso Machine',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ice Machine',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Microwave Oven',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Blender',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Coffee Grinder',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Not Available'],
                                        ['title' => 'Not Calibrated'],
                                        ['title' => 'Not in Use'],
                                    ]
                                ]
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'RHS Processes',
                    'total-base' => 14,
                    'total-points' => 14,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Raw Materials w/ Standard Quality',
                            'total-base' => 9,
                            'total-points' => 9,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Proper handling of received stocks',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Raw Material w/ Standard Quality',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Use of Approved Raw Material',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Correct Receiving & Handling Procedures',
                            'total-base' => 5,
                            'total-points' => 5,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Proper storage of Raw Materials',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'In Process',
                    'total-base' => 94,
                    'total-points' => 94,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Cake Slicing (Counter Skills)',
                            'total-base' => 9,
                            'total-points' => 9,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Knowledge and Proper Use of T&U',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct Slicing (Size and Proportion)',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct Storage and Sticker Monitoring',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Pre-Preparation',
                            'total-base' => 9,
                            'total-points' => 9,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct Beans in use',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct Milk',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct grinder setting',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Too Coarse'],
                                        ['title' => 'Too Fine'],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'title' => 'Brewing (Barista Skills)',
                            'total-base' => 9,
                            'total-points' => 9,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Proper Grind Distribution is Done',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Correct Tamping is Done',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Met Brewing Time',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Under Extracted'],
                                        ['title' => 'Over Extracted'],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'title' => 'Steaming (Steaming, Heating Temp & Batch Size)',
                            'total-base' => 7,
                            'total-points' => 7,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Milk',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cake and Pastry',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mary Grace Chocolate',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'title' => 'Reheating',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Muscovado Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Valencia Cream',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Chocolate Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Caramel Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Incorrect Heating Procedure/Time/Temperature'],
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'title' => 'Staging (Holding Time, Shelflife, Labels, Tags)',
                            'total-base' => 20,
                            'total-points' => 20,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Muscovado Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Valencia Cream',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Almond Cream',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Raspberry Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Chocolate Sauce',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Fruit Slices',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mary Grace Chocolate',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Iced Tea',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cake and Pastry',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Milk',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'No Label/Tag'],
                                        ['title' => 'Improper Label/Tag'],
                                        ['title' => 'Beyond Secondary Shelf-Life'],
                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Vanilla Cream',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Caramel Sauce',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Gold Standard Attributes',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Ensaymada',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cheesroll',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Assembly',
                            'total-base' => 30,
                            'total-points' => 30,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Standard and correct packaging materials',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cake and Pastry',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Pasta',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Salad',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Pizza',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Rice Meal',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mains',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Iced Tea',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Coffee',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Beverage Shake',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => [
                                        ['title' => 'Underportioned'],
                                        ['title' => 'Overportioned'],
                                        ['title' => 'Incorrect Ingredients'],
                                        ['title' => 'Incomplete Components'],

                                    ]
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'New Product Production Process',
                    'total-base' => 20,
                    'total-points' => 20,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Preparation',
                            'total-base' => 8,
                            'total-points' => 8,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Standard and correct tools',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cooking and Holding Equipment',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Raw materials with standard quality',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'In-process pre-preparation',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Cooking',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Cooking Time & other SOP`s',
                                    'is-aon' => 0,
                                    'base' => 4,
                                    'points' => 4,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Staging',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Items with correct holding time',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'GS Attributes',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Assembly',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Standard Packaging',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'GSA of Assembled Product',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                    ]
                ],
            ],
            'critical-deviation' =>[
                [
                    'title'=> 'Critical & Major SD',
                    'is-sd' => 1,
                    'is-location' => [
                        ['title' => 'Food'],
                        ['title' => 'Packaging'],
                        ['title' => 'Equipment'],
                        ['title' => 'Dining Area'],
                        ['title' => 'Other Rooms']
                    ],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
                [
                    'title'=> 'Spoiled/Lapsed product',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [
                        ['title' => 'Baked Goods'],
                        ['title' => 'Salad'],
                        ['title' => 'Appetizer'],
                        ['title' => 'Pasta'],
                        ['title' => 'Pizza'],
                        ['title' => 'Rice Meal'],
                        ['title' => 'Sandwich'],
                        ['title' => 'Mains'],
                        ['title' => 'Drinks'],
                    ],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'product' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ]
            ]
        ],
        [
            'category' => 'Service',
            'total-base' => 104,
            'total-points' => 104,
            'percent' => 100,
            'sub-category' => [
                [
                    'title' => 'Speed And Accuracy',
                    'total-base' => 0,
                    'total-points' => 0,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Cashier TAT',
                            'total-base' => 5,
                            'total-points' => 5,
                            'deviation' => [
                                [
                                    'cashier_name' => '',
                                    'product_ordered' => '',
                                    'ot_time' => '',
                                    'ot' => '',
                                    'assembly' => '',
                                    'base_assembly_point' => 1,
                                    'assembly_point' => 1,
                                    'serving_time' => '00:05',
                                    'tat_time' => '',
                                    'base_tat_point' => 1,
                                    'tat_point' => 1,
                                    'fst_time' => '',
                                    'base_fst_point' => 3,
                                    'fst_point' => 3,
                                    'remarks' => '',
                                ]
                            ]
                        ],
                        [
                            'title' => 'Server CAT',
                            'total-base' => 8,
                            'total-points' => 8,
                            'deviation' => [
                                [
                                    'server_name' => '',
                                    'product_ordered' => '',
                                    'ot_time' => '',
                                    'ot' => '',
                                    'assembly' => '',
                                    'base_assembly_point' => 1,
                                    'assembly_point' => 1,
                                    'serving_time' => '00:05',
                                    'tat_time' => '',
                                    'base_tat_point' => 1,
                                    'tat_point' => 1,
                                    'fst_time' => '',
                                    'base_fst_point' => 5,
                                    'fst_point' => 5,
                                    'att_time' => '',
                                    'base_att_point' => 1,
                                    'att_point' => 1,
                                    'remarks' => '',
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Counter Service System',
                    'total-base' => 18,
                    'total-points' => 18,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Personnel with personalized greetings/with welcome to the brand',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Counter crew suggests appropriately',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Customer is informed of amount of bill/bill received & change',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Change is given on the palm of the customer/receipt given directly to customer',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Products are properly and neatly presented (3 eye system)',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Coins and Bills availability',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                    ]
                ],
                [
                    'title' => 'Service Sequence',
                    'total-base' => 37,
                    'total-points' => 37,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'With correct and appropriate crew positioning and manning',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Guest are seatted and handed the Menu',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Server with full attention during order-taking',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Temporary Receipt and Order List is placed on customer table.',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Correct Utensils is set to customer table and placed in glassine or EQ plate',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Customer is updated on status of orders',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'There is a sequential delivery, assembly and dispatch of orders',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'There is a person assigned to support and ease speed',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'There are actions to speed up serving of products',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Manager conducts table hopping and interacting with customers',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Manager is on floor & visibly managing service',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                    ]
                ],
                [
                    'title' => 'Dining Service System',
                    'total-base' => 12,
                    'total-points' => 12,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Product is presented upon serving of orders',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Dining task is prioritized according to need',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Pre-bussing and bussing standard (using correct chemicals and cleaning tools)',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Spot mopping/cleaning is done as needed',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ],
                [
                    'title' => 'Customer  Service',
                    'total-base' => 17,
                    'total-points' => 17,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Personnel greet customer in a friendly & sincere manner upon entry & exit',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Personnel are friendly, warm & with personalized greetings												',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Personnel are courteous, accommodating and flexible',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Cafe personnel are attentive and ready to assist',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Manager is helpful, ready to assist and visible in Dining Area',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ],
                [
                    'title' => 'People Service Image',
                    'total-base' => 20,
                    'total-points' => 20,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Store personnel are in complete/correct uniform, well-groomed & neat in appearance',
                            'is-aon' => 0,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Store personnel practice good hygiene',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Store personnel know their products and services offered',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Store personnel with good  command of communication',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Managers & crew with good and refined manners',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Customer inquries and complaints are effectively attended',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ],
            ],
            'critical-deviation' =>[
                [
                    'title'=> 'Customer Complaint',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [
                        ['title' => 'Food Related'],
                        ['title' => 'Service Related'],
                        ['title' => 'Ambiance Related'],
                        ['title' => 'Others'],
                    ],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
                [
                    'title'=> 'Product Availability (Less 3% for non flagship and 5% for flagship/core products)',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
                [
                    'title'=> 'Dining Temperature',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [
                        ['title' => '<21°C'],
                        ['title' => '>25°C'],
                    ],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
                [
                    'title'=> 'Background Music',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [
                        ['title' => 'No Music'],
                        ['title' => 'Too Soft'],
                        ['title' => 'Too Loud'],
                        ['title' => 'Unapproved Playlist'],
                    ],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ],
            ]
        ],
        [
            'category' => 'Cleanliness',
            'total-base' => 139,
            'total-points' => 139,
            'percent' => 100,
            'sub-category' => [
                [
                    'title' => 'Customer Area',
                    'total-base' => 88,
                    'total-points' => 88,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Building And Grounds',
                            'total-base' => 14,
                            'total-points' => 14,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Signages',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Parking/Landscaping/Plants/Lamp Posts/PWD Ramp',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Glass panels/Blinds/Door/Window Shutter/Roll Up Door/Backlighted Column',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Floor / Stair (Exterior Area, Dining Area, Function Room',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Walls / Mural (Exterior Area, Dining Area, Function Room)',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ceiling / Lights and Fixtures (Alfresco, Dining Area, Function)',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Canopy/ Roof/ Air Curtain',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Ambiance Specifics',
                            'total-base' => 23,
                            'total-points' => 23,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Flowers/ Letters / Laminated table signages',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mechanical Birds/ Mechanical dragon fly',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Christmas light/ Lamps/ Special Bulbs',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Fresh Plants/ Artificial Plants',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Jars/ water/ faucet',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],


                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment , T/U',
                            'total-base' => 21,
                            'total-points' => 21,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'ACU / Ceiling Fans / Exhaust Vents / Air Vents',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tray / Wares/ Carafe',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => ' Tables / Chairs/ Couches /  High Chair / Bag Hanger',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'POS / Card Terminal / Counter top / Optima Display / Server Station',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Kids Corner/ Toys/ Magazines',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Standing Chiller/ Freezer /DisplayShowcase',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],


                            ]
                        ],
                        [
                            'title' => 'Sanitary Facilities',
                            'total-base' => 16,
                            'total-points' => 16,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Floor',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Walls / Doors / Wall Partition / Mirror / Bag Hanger ',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ceiling / Lights and Fixtures',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Exhaust System / Air vents',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Toilet / Urinal / Wash sink and Fixtures',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tissue/Handsoap/Tissue Holder/ Soap and sanitizer dispenser/ Hand dryer / Diaper changer',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Total dÃ©cor',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Service Station / Garbage Bins',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],



                            ]
                        ],
                        [
                            'title' => 'Merchandising Materials',
                            'total-base' => 14,
                            'total-points' => 14,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Frames Tripod and Sintra Board/ Shelves/',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Optima Display',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Digital Display',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Menu Book/ QR Code',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],

                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'Non-Customer Area',
                    'total-base' => 51,
                    'total-points' => 51,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Floor / Stairs',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],

                            ]
                        ],
                        [
                            'title' => 'Wall / Door',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],




                            ]
                        ],
                        [
                            'title' => 'Ceiling, Lights and Fixtures',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],




                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment, T/Us',
                            'total-base' => 33,
                            'total-points' => 33,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Wares / All SS facilities / Counter Water Faucet / Work Tables / Shelves / Push Cart',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Exhaust & Ventilation System / Air Curtain / Electrical Panel Board',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Water Filter',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Dishwashing Machine',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Freezers',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Chillers',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ice machine / Blender/Espresso Machine / Microwave Oven / Oven Toaster /CCTV',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                    ]
                ],
            ],
            'critical-deviation' =>[
                [
                    'title'=> 'Critical Deviations: Strong Foul Odor',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ]
            ]
        ],
        [
            'category' => 'Condition',
            'total-base' => 175,
            'total-points' => 175,
            'percent' => 100,
            'sub-category' => [
                [
                    'title' => 'Customer Area',
                    'total-base' => 92,
                    'total-points' => 92,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Building And Grounds',
                            'total-base' => 14,
                            'total-points' => 14,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Signages',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Parking/Landscaping/Plants/Lamp Posts/PWD Ramp',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Glass panels/Blinds/Door/Window Shutter/Roll Up Door/Backlighted Column',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Floor / Stair (Exterior Area, Dining Area, Function Room',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Walls / Mural (Exterior Area, Dining Area, Function Room)',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ceiling / Lights and Fixtures (Alfresco, Dining Area, Function)',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Canopy/ Roof/ Air Curtain',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Ambiance Specifics',
                            'total-base' => 23,
                            'total-points' => 23,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Flowers/ Letters / Laminated table signages',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mechanical Birds/ Mechanical dragon fly',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Christmas light/ Lamps/ Special Bulbs',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Fresh Plants/ Artificial Plants',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Jars/ water/ faucet',
                                    'is-aon' => 0,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment , T/U',
                            'total-base' => 21,
                            'total-points' => 21,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'ACU / Ceiling Fans / Exhaust Vents / Air Vents',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tray / Wares/ Carafe',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => ' Tables / Chairs/ Couches /  High Chair / Bag Hanger',
                                    'is-aon' => 1,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'POS / Card Terminal / Counter top / Optima Display / Server Station',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Kids Corner/ Toys/ Magazines',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Standing Chiller/ Freezer /DisplayShowcase',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Sanitary Facilities',
                            'total-base' => 16,
                            'total-points' => 16,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Floor',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Walls / Doors / Wall Partition / Mirror / Bag Hanger ',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ceiling / Lights and Fixtures',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Exhaust System / Air vents',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Toilet / Urinal / Wash sink and Fixtures',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Tissue/Handsoap/Tissue Holder/ Soap and sanitizer dispenser/ Hand dryer / Diaper changer',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Total dÃ©cor',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Service Station / Garbage Bins',
                                    'is-aon' => 1,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Merchandising Materials',
                            'total-base' => 12,
                            'total-points' => 12,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Frames Tripod and Sintra Board/ Shelves/',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Optima Display',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Digital Display',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Menu Book/ QR Code',
                                    'is-aon' => 0,
                                    'base' => 3,
                                    'points' => 3,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],

                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'Non-Customer Area',
                    'total-base' => 51,
                    'total-points' => 51,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Floor / Stairs',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Wall / Door',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Ceiling, Lights and Fixtures',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Kitchen',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Bar',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Storage Cabinets / Other Rooms',
                                    'is-aon' => 0,
                                    'base' => 2,
                                    'points' => 2,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment, T/Us',
                            'total-base' => 33,
                            'total-points' => 33,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Wares / All SS facilities / Counter Water Faucet / Work Tables / Shelves / Push Cart',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Exhaust & Ventilation System / Air Curtain / Electrical Panel Board',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Water Filter',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Dishwashing Machine',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Freezers',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Chillers',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ice machine / Blender/Espresso Machine / Microwave Oven / Oven Toaster /CCTV',
                                    'is-aon' => 1,
                                    'base' => 5,
                                    'points' => 5,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'Safety And Security',
                    'total-base' => 30,
                    'total-points' => 30,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Fire Extinguisher / Emergency Light',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Gas Suppression System / Water Sprinkler / Smoke Alarm',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'First Aid Kit / Emergency Kit',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Protective Gears (mask, heat resistant gloves, goggles)',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Statutory Sign / Wet Floor Sign /  Convenience Outlet',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Evacuation Plan / Emergency Telephone Numbers',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Bill Detector / Fire Igniter',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Rain Mat / Ladder (Optional)',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Availability of MSDS',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'CCTV installed',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                    ]
                ]
            ],
            'critical-deviation' =>[
                [
                    'title'=> 'Critical Deviations: Strong Foul Odor',
                    'is-sd' => 0,
                    'is-location' => [],
                    'is-product' => [],
                    'is-remarks' => 1,
                    'is-score' => [
                        ['title' => 3],
                        ['title' => 5],
                        ['title' => 10],
                        ['title' => 15]
                    ],
                    'is-dropdown' => [],
                    'sd' => '',
                    'location' => '',
                    'remarks' => '',
                    'score' => '',
                    'dropdown' => '',
                ]
            ]
        ],
        [
            'category' => 'Document',
            'total-base' => 41,
            'total-points' => 41,
            'percent' => 40,
            'sub-category' => [
                [
                    'title' => 'Primary Systems',
                    'total-base' => 11,
                    'total-points' => 11,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Food',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'People Training Calendar (Product Knowledge)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Product Traceability (MT Workbook)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Shelflife Monitoring (MT Workbook)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Equipment Checklist (MT Workbook)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Service',
                            'total-base' => 4,
                            'total-points' => 4,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Manager Checklist',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Server Checklist',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cashier Checklist',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Counter Checklist',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Ambiance',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'PM Checklist/ PM Report for 3months ',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Store with  cushion, Laundry frequency',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'All repairs Ticket number',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Support Systems',
                    'total-base' => 14,
                    'total-points' => 14,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Food Safety',
                            'total-base' => 6,
                            'total-points' => 6,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Pest Control Report 3months',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Pest Control walk through Checklist',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Pest Sighting Monitoring',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Weighing Scale and Thermometer Calibration Monitoring',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Rancidity Test (Bar only)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Water Potability',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Inventory Management',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Stock Report',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Stock Update',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Ending Inventory (Month end inventory)',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Feedback Management',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Feedback Summary',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Corrective Action',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Preventive Action',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Repair Maintenance',
                            'total-base' => 2,
                            'total-points' => 2,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'PM Calendar',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'IT and Engineering Ticketing System',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Strategic System',
                    'total-base' => 3,
                    'total-points' => 3,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Approved Manpower',
                            'total-base' => 1,
                            'total-points' => 1,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Manpower Study',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Sales Analysis',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'BGSR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Sales Report Summary',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                    ],
                ],
                [
                    'title' => 'Management System',
                    'total-base' => 13,
                    'total-points' => 13,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'BIR Report',
                            'total-base' => 8,
                            'total-points' => 8,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Sales Columnar',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'POS Permit',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BIR Ask for your Receipt',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Deposit Logbook',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Cashier Cutoff Summary Logbook',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Official Receipt 3 Booklet',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Transmittal Pad 3 pad',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'BIR 2303/ Certificate of Registration',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],

                            ]
                        ],
                        [
                            'title' => 'Permit and Licenses',
                            'total-base' => 5,
                            'total-points' => 5,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Business Permit',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Sanitary Permit',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Fire Certificate',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Health Certificate',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Mayors Permit',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                            ]
                        ],
                    ],
                ],
            ]
        ],
        [
            'category' => 'People',
            'total-base' => 12,
            'total-points' => 12,
            'percent' => 60,
            'sub-category' => [
                [
                    'title' => 'Manpower Completion',
                    'total-base' => 1,
                    'total-points' => 1,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Manpower line up complete and adequate to support the service.',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ],
                [
                    'title' => 'Manpower Competence, Behavior and Manners',
                    'total-base' => 5,
                    'total-points' => 5,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'is-na' => 1,
                            'title' => 'Personnel have undergone training and certified to their position.',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Shift rounds are conducted and concerns are addressed accordingly.',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'All employee knows and understands the company Mission, Vision and Core Values',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'All employees follow the Set Codes of Discipline',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' => 1,
                            'title' => 'Every store personnel treat each other well and with respect.',
                            'is-aon' => 1,
                            'base' => 1,
                            'points' => 1,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                    ]
                ],
                [
                    'title' => 'Compliance to Regulatory Law',
                    'total-base' => 6,
                    'total-points' => 6,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Store is a safe workplace.',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Well lighted',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'Proper ventilation',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'With emergency exits and light',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                        [
                            'title' => 'Store is compliance to Government Regulations.',
                            'total-base' => 3,
                            'total-points' => 3,
                            'deviation' => [
                                [
                                    'is-na' => 1,
                                    'title' => 'Provision for breaks and rest days',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'OT, Leaves are paid on time.',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' => 1,
                                    'title' => 'OBP are filed and approved on time',
                                    'is-aon' => 1,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ]
                            ]
                        ],
                    ],
                ],
            ]
        ]
    ];
    public function setActive($index)
    {
        $this->active_index = $index;
    }
    public function mount($id = null)
    {
    //    dd( json_encode($this->form));
     /*   $saved_data = AuditTemplate::where('type', 1)->first();
       $this->form = json_decode($saved_data->template, true); */
       $this->auditForm = AuditFormModel::find($id);
       $this->sanitary_list = SanitaryModel::get();
       $this->onCaculatePoints();
       $this->store = Store::find($this->auditForm->store_id);
    }
    public function render()
    {
       $this->onCaculatePoints();
        return view('livewire.audit.audit-form')->extends('layouts.app');
    }
    public function updatedForm($value, $key)
    {
        // dd($this->form);
        StoreRecord::find(1)->update(['wave1' => $this->form]);
    }
    public function onCaculatePoints()
    {
        foreach ($this->form as $categoryIndex => &$category) {
            $category['total-base'] = 0;
            $category['total-points'] = 0;
            foreach ($category['sub-category'] as $subCategoryIndex => &$subCategory) {
                $subCategory['total-base'] = 0;
                $subCategory['total-points'] = 0;
                foreach ($subCategory['deviation'] as $deviationIndex => &$deviation) {
                    if(isset($deviation['deviation'])){
                        foreach ($deviation['deviation'] as $key => $subCategoryDeviation) {
                            if (isset($subCategoryDeviation['is-na']) && $subCategoryDeviation['is-na'] == 1) {
                                $subCategory['total-base'] += $subCategoryDeviation['base'] ?? 0;
                                $subCategory['total-points'] += $subCategoryDeviation['points'] ?? 0;
                            } 
                        }
                    }else{
                        if (isset($deviation['is-na']) && $deviation['is-na'] == 1) {
                            $subCategory['total-base'] += $deviation['base'] ?? 0;
                            $subCategory['total-points'] += $deviation['points'] ?? 0;
                        } 
                    }
                }
                $category['total-base'] += $subCategory['total-base'] ?? 0;
                $category['total-points'] += $subCategory['total-points'] ?? 0;
            }
            if(isset($category['critical-deviation'])){
                // $category['percent'] = 0;
                foreach ($category['critical-deviation'] as $key => $critical_deviation) {
                    $category['percent'] -= (int)$critical_deviation['score'];
                }
            }
        }
    }
    public function onRemoveService($category_index, $sub_category_index, $sub_sub_category_index, $sub_sub_sub_category_index)
    {
        // Check if the service index is valid
        if (isset($this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][$sub_sub_sub_category_index])) {
            array_splice(
                $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'],
                $sub_sub_sub_category_index,
                1
            );
        }
    }
    public function onAddService($category_index, $sub_category_index, $sub_sub_category_index)
    {
        $newService = [
            'cashier_name' => '',
            'product_ordered' => '',
            'ot_time' => '',
            'ot' => '',
            'assembly' => '',
            'base_assembly_point' => 1,
            'assembly_point' => 1,
            'serving_time' => '00:05',
            'tat_time' => '',
            'base_tat_point' => 1,
            'tat_point' => 1,
            'fst_time' => '',
            'base_fst_point' => 3,
            'fst_point' => 3,
            'remarks' => '',
        ];
        $this->form[$category_index]['sub-category'][$sub_category_index]['deviation'][$sub_sub_category_index]['deviation'][] = $newService;
        // dd($this->form);
    }
    
}