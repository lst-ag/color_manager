<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Color Manager',
    'description' => 'Extension to manage colors in the TYPO3 backend.',
    'category' => 'be',
    'author' => 'Christian Fries',
    'author_email' => 'christian.fries@lst.team',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '2.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'backend_module' => '2.0.0-2.99.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'autoload' => [
        'classmap' => ['Classes']
    ],
];
