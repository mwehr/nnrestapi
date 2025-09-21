<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Rest-Api example',
    'description' => 'Example extension for EXT:nnrestapi',
    'category' => 'frontend',
    'author' => 'yourcompany.de',
    'author_email' => 'your@email.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.0.0-13.9.99',
            'nnhelpers' => '13.0.0-13.9.9',
            'nnrestapi' => '13.0.0-13.9.9',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
