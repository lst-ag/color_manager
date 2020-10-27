<?php
declare(strict_types = 1);

$llFile = 'LLL:EXT:color_manager/Resources/Private/Language/locallang_db.xlf:';

return [
    'ctrl' => [
        'title' => $llFile . 'color',
        'label' => 'name',
        'label_userFunc' => 'LST\ColorManager\UserFunc\Tca->colorTitle',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',

        'delete' => 'deleted',

        'searchFields' => 'name,color,',
        'iconfile' => 'EXT:color_manager/Resources/Public/Icons/tx_colormanager_domain_model_color.gif'
    ],
    'types' => [
        '1' => ['showitem' => 'name, color, '],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => 0,
            'config' => [
                'type' => 'passthrough',
                'default' => -0,
            ],
        ],

        'name' => [
            'exclude' => 0,
            'label' => $llFile . 'color.name',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim,required'
            ]
        ],
        'color' => [
            'exclude' => 0,
            'label' => $llFile . 'color.color',
            'config' => [
                'type' => 'input',
                'renderType' => 'colorpicker',
                'size' => 10,
                'eval' => 'trim,required',
            ],
        ],
    ],
];
