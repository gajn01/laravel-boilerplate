<?php

namespace App\Http\Livewire\Audit;

use Livewire\Component;
use App\Models\AuditForm as AuditFormModel;
use App\Models\Store;
use App\Models\StoreRecord;


class AuditForm extends Component
{
    public $auditForm;
    public  $store;
    public $active_index = 0;
    public $form =  [
        [
            'category' =>'Food',
            'total-base' => 94,
            'total-points' => 94,
            'percent' => 0,
            'sub-category' =>[
                [
                    'title' => 'Ensaymada',
                    'total-base' => 15,
                    'total-points' => 15,
                    'percent' => 20,
                    'deviation' => [
                        [
                            'is-na' =>1,
                            'title' => 'Apperance / No SD',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => 'Deformed',
                            'deviation-dropdown' => [
                                ['title' => 'Deformed'],
                                ['title' => 'Burnt'],
                                ['title' => 'Pale'],
                                ['title' => 'With SD'],
                            ]
                        ],
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                    'total-points' => 15,
                    'percent' => 20,
                    'deviation' => [
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                    'total-points' => 14,
                    'percent' => 30,
                    'deviation' => [
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                    'total-points' => 10,
                    'percent' => 10,
                    'deviation' => [
                        [
                            'id' => 1,
                            'is-na' =>1,
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
                            'is-na' =>1,
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
                                    'is-na' =>1,
                                    'title' => 'EQ',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                                    'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'PU',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'MM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'BR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'FG',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'LMS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'BB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'AP',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CH',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'VT',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'SSCV',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CK',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'SW',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'LI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'MB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'BA',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TAS/SS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'DCC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TLC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
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
                                    'is-na' =>1,
                                    'title' => 'PU',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'LMS',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'AP',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'CH',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'VT',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TR',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'TI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],
                                [
                                    'is-na' =>1,
                                    'title' => 'SSCV',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'CK',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'SW',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'CM',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'CC',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'LI',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
                                    'title' => 'MB',
                                    'is-aon' => 0,
                                    'base' => 1,
                                    'points' => 1,
                                    'remarks' => '',
                                    'critical-deviation' => '',
                            'deviation-dropdown' => []
                                ],[
                                    'is-na' =>1,
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
            ]
        ],
        [
            'category' =>'Production Process',
            'total-base' => 213,
            'total-points' => 213,
            'percent' => 0,
            'sub-category' =>[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ]   ,[
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
                                ],[
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
                                ],[
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
                                ],[
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
                                ],[
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
                        ],[
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
            ]
        ],
        [
            'category' =>'Service',
            'total-base' => 104,
            'total-points' => 104,
            'percent' => 0,
            'sub-category' =>[
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
                           /*  'deviation' => [
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
                            ] */
                        ],
                        [
                            'title' => 'Server CAT',
                            'total-base' => 8,
                            'total-points' => 8,
                            /* 'deviation' => [
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
                            ] */
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
                            'is-na' =>1,
                            'title' => 'Personnel with personalized greetings/with welcome to the brand',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Counter crew suggests appropriately',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Customer is informed of amount of bill/bill received & change',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Change is given on the palm of the customer/receipt given directly to customer',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Products are properly and neatly presented (3 eye system)',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
                            'title' => 'With correct and appropriate crew positioning and manning',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Guest are seatted and handed the Menu',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Server with full attention during order-taking',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Temporary Receipt and Order List is placed on customer table.',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Correct Utensils is set to customer table and placed in glassine or EQ plate',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Customer is updated on status of orders',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'There is a sequential delivery, assembly and dispatch of orders',
                            'is-aon' => 1,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
                            'title' => 'Product is presented upon serving of orders',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Dining task is prioritized according to need',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Pre-bussing and bussing standard (using correct chemicals and cleaning tools)',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
                            'title' => 'Personnel greet customer in a friendly & sincere manner upon entry & exit',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Personnel are friendly, warm & with personalized greetings												',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Personnel are courteous, accommodating and flexible',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Cafe personnel are attentive and ready to assist',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
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
                            'is-na' =>1,
                            'title' => 'Store personnel are in complete/correct uniform, well-groomed & neat in appearance',
                            'is-aon' => 0,
                            'base' => 5,
                            'points' => 5,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Store personnel practice good hygiene',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Store personnel know their products and services offered',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Store personnel with good  command of communication',
                            'is-aon' => 0,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
                            'title' => 'Managers & crew with good and refined manners',
                            'is-aon' => 1,
                            'base' => 3,
                            'points' => 3,
                            'remarks' => '',
                            'critical-deviation' => '',
'deviation-dropdown' => []
                        ],
                        [
                            'is-na' =>1,
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
            ]
        ],
        [
            'category' =>'Cleanliness & Condition',
            'total-base' => 104,
            'total-points' => 104,
            'percent' => 0,
            'sub-category' =>[
                [
                    'title' => 'Customer Area',
                    'cln-total-base' => 83,
                    'cln-total-points' => 83,
                    'con-total-base' => 90,
                    'con-total-points' => 90,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Building And Grounds',
                            'cln-total-base' => 14,
                            'cln-total-points' => 14,
                            'con-total-base' => 18,
                            'con-total-points' => 18,
                            'deviation' => [
                                [
                                    'title' => 'Signages',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Parking/Landscaping/Plants/Lamp Posts/PWD Ramp',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Glass panels/Blinds/Door/Window Shutter/Roll Up Door/Backlighted Column',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Canopy / Roof / Air Curtain',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Floor / Stairs',
                                    'is-na' => 1,
                                    'total-base' => 1,
                                    'total-points' => 1,
                                    'deviation' => [
                                        [
                                            'title' => ' a. Exterior Area / Dining Area / Function Room ',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 1,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                                [
                                    'title' => 'Walls / Mural',
                                    'is-na' => 1,
                                    'total-base' => 1,
                                    'total-points' => 1,
                                    'deviation' => [
                                        [
                                            'title' => ' a. Exterior Area / Dining Area / Function Room ',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 1,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                                [
                                    'title' => 'Ceiling / Lights and Fixtures',
                                    'is-na' => 1,
                                    'total-base' => 1,
                                    'total-points' => 1,
                                    'deviation' => [
                                        [
                                            'title' => 'a. Alfresco / Dining Area / Function Room',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 1,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                            ]
                        ],
                        [
                            'title' => 'Ambiance Specificts',
                            'cln-total-base' => 23,
                            'cln-total-points' => 23,
                            'con-total-base' => 17,
                            'con-total-points' => 17,
                            'deviation' => [
                                [
                                    'title' => 'Flowers/ Letters / Laminated table signages*',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Mechanical Birds/ Mechanical dragon fly**',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Christmas light/ Lamps/ Special Bulbs',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Fresh Plants/ Artificial Plants',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Jars/ water/ faucet',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment , T/U',
                            'cln-total-base' => 21,
                            'cln-total-points' => 21,
                            'con-total-base' => 26,
                            'con-total-points' => 26,
                            'deviation' => [
                                [
                                    'title' => 'ACU / Ceiling Fans / Exhaust Vents / Air Vents',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Tray / Wares/ Carafe',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => ' Tables / Chairs/ Couches /  High Chair / Bag Hanger',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'POS / Card Terminal / Counter top / Optima Display / Server Station',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Kids Corner/ Toys/ Magazines',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Standing Chiller/ Freezer /DisplayShowcase',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Sanitary Facilities',
                            'cln-total-base' => 16,
                            'cln-total-points' => 16,
                            'con-total-base' => 19,
                            'con-total-points' => 19,
                            'deviation' => [
                                [
                                    'title' => 'Floor',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Walls / Doors / Wall Partition / Mirror / Bag Hanger',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => ' Ceiling / Lights and Fixtures',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Exhaust System / Air vents',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Toilet / Urinal / Wash sink and Fixtures',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Tissue/Handsoap/Tissue Holder/ Soap and sanitizer dispenser/ Hand dryer / Diaper changer',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Total dÃ©cor',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Service Station / Garbage Bins',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 2,
                                    'cln-points' => 2,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 2,
                                    'con-points' => 2,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                            ]
                        ],
                        [
                            'title' => 'Merchandising Materials',
                            'cln-total-base' => 21,
                            'cln-total-points' => 21,
                            'con-total-base' => 26,
                            'con-total-points' => 26,
                            'deviation' => [
                                [
                                    'title' => 'Frames Tripod and Sintra Board/ Shelves',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Optima Display',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Digital Display',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Menu Book/ QR Code',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 0,
                                    'con-base' => 3,
                                    'con-points' => 3,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                
                            ]
                        ],
                    ]
                ],
                [
                    'title' => 'Non-Customer Area',
                    'cln-total-base' => 53,
                    'cln-total-points' => 53,
                    'con-total-base' => 53,
                    'con-total-points' => 53,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Building And Grounds',
                            'cln-total-base' => 18,
                            'cln-total-points' => 18,
                            'con-total-base' => 18,
                            'con-total-points' => 18,
                            'deviation' => [
                                [
                                    'title' => 'Floor / Stairs',
                                    'is-na' => 1,
                                    'total-base' => 6,
                                    'total-points' => 6,
                                    'deviation' => [
                                        [
                                            'title' => ' a. Kitchen',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => ' b. Bar',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => 'c. Storage Cabinets / Other Rooms',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                                [
                                    'title' => 'Wall / Door',
                                    'is-na' => 1,
                                    'total-base' => 6,
                                    'total-points' => 6,
                                    'deviation' => [
                                        [
                                            'title' => ' a. Kitchen',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => ' b. Bar',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => 'c. Storage Cabinets / Other Rooms',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                                [
                                    'title' => 'Ceiling, Lights and Fixtures',
                                    'is-na' => 1,
                                    'total-base' => 6,
                                    'total-points' => 6,
                                    'deviation' => [
                                        [
                                            'title' => ' a. Kitchen',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => ' b. Bar',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                        [
                                            'title' => 'c. Storage Cabinets / Other Rooms',
                                            'cln-is-na' => 1,
                                            'cln-is-aon' => 0,
                                            'cln-base' => 2,
                                            'cln-points' => 2,
                                            'cln-remarks' => '',
                                            'con-is-na' => 1,
                                            'con-is-aon' => 0,
                                            'con-base' => 2,
                                            'con-points' => 2,
                                            'con-remarks' => '',
                                            'critical-deviation' => '',
'deviation-dropdown' => []
                                        ],
                                    ]
                                ],
                              
                            ]
                        ],
                        [
                            'title' => 'Facilities, Equipment , T/Us',
                            'cln-total-base' => 33,
                            'cln-total-points' => 33,
                            'con-total-base' => 35,
                            'con-total-points' => 35,
                            'deviation' => [
                                [
                                    'title' => 'Wares / All SS facilities / Counter Water Faucet / Work Tables / Shelves / Push Cart',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 0,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ], 
                                [
                                    'title' => 'Exhaust & Ventilation System / Air Curtain / Electrical Panel Board',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Water Filter',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Dishwashing Machine',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 3,
                                    'cln-points' => 3,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Freezers',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => 'Chillers',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                [
                                    'title' => ' Ice machine / Blender/Espresso Machine / Microwave Oven / Oven Toaster /CCTV',
                                    'cln-is-na' => 1,
                                    'cln-is-aon' => 1,
                                    'cln-base' => 5,
                                    'cln-points' => 5,
                                    'cln-remarks' => '',
                                    'con-is-na' => 1,
                                    'con-is-aon' => 1,
                                    'con-base' => 5,
                                    'con-points' => 5,
                                    'con-remarks' => '',
                                    'critical-deviation' => '',
'deviation-dropdown' => []
                                ],
                                
                            ]
                        ]
                    ]
                ],
                [
                    'title' => 'Safety And Security',
                    'cln-total-base' => 0,
                    'cln-total-points' => 0,
                    'con-total-base' => 30,
                    'con-total-points' => 30,
                    'percent' => 100,
                    'deviation' => [
                        [
                            'title' => 'Fire Extinguisher / Emergency Light',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Gas Suppression System / Water Sprinkler / Smoke Alarm',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'First Aid Kit / Emergency Kit',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Protective Gears (mask, heat resistant gloves, goggles)',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Statutory Sign / Wet Floor Sign /  Convenience Outlet',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Evacuation Plan / Emergency Telephone Numbers',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Bill Detector / Fire Igniter',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Rain Mat / Ladder (Optional)',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'Availability of MSDS',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ],
                        [
                            'title' => 'CCTV installed',
                            'cln-is-na' => 0,
                            'cln-is-aon' => 0,
                            'cln-base' => 0,
                            'cln-points' => 0,
                            'cln-remarks' => '',
                            'con-is-na' => 1,
                            'con-is-aon' => 1,
                            'con-base' => 3,
                            'con-points' => 3,
                            'con-remarks' => '',
                            'critical-deviation' => '',
                            'deviation-dropdown' => []
                        ]
                    ]
                ]
            ]
        ],
        [
            'category' =>'Document',
            'total-base' => 41,
            'total-points' => 41,
            'percent' => 40,
            'sub-category' =>[
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
            'category' =>'People',
            'total-base' => 12,
            'total-points' => 12,
            'percent' => 60,
            'sub-category' =>[
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
        ],
    ];
    public $datatest = [
        [
            'category' =>'Document',
            'total-base' => 41,
            'total-points' => 41,
            'percent' => 40,
            'sub-category' =>[
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
                            ]
                        ]
                    ]
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
        $this->auditForm = AuditFormModel::find($id);
        // $this->sanitary_list = SanitaryModel::get();
        $this->store = Store::find($this->auditForm->store_id);
    }
    public function render()
    {

        $test = StoreRecord::first();
        $this->form = json_decode($test->wave1, true);
        return view('livewire.audit.audit-form')->extends('layouts.app');
    }
    public function updatedDatatest($newValue, $oldValue)
    {
        foreach ($this->datatest as &$category) {
            $totalBase = 0;
            $totalPoints = 0;
    
            foreach ($category['sub-category'] as &$subCategory) {
                $subTotalBase = 0;
                $subTotalPoints = 0;
    
                foreach ($subCategory['deviation'] as &$deviation) {
                    // Update sub-total points based on each deviation's points
                    $subTotalBase += $deviation['base'];
                    $subTotalPoints += $deviation['points'];
                }
    
                // Update sub-category's total-base and total-points
                $subCategory['total-base'] = $subTotalBase;
                $subCategory['total-points'] = $subTotalPoints;
    
                // Update category's total-base and total-points
                $totalBase += $subTotalBase;
                $totalPoints += $subTotalPoints;
            }
    
            $category['total-base'] = $totalBase;
            $category['total-points'] = $totalPoints;
        }
    }
}
