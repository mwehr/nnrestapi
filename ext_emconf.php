<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'TYPO3 Restful API by 99°',
    'description' => 'Build a REST Api for your TYPO3 project. Equipped with everything you need: Routing with annotations. User authentication. Fileupload and FAL conversion. Testbed and automatic documentation of your API. The backend module comes with a "Kickstarter" to get your RESTful API up and running in minutes.',
    'category' => 'services',
    'author' => '99grad.de',
    'author_email' => 'david@99grad.de',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 0,
    'version' => '2.0.4',
    'constraints' => [
        'depends' => [
            'typo3' => '12.1.0-12.9.99',
            'nnhelpers' => '2.0.0',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
