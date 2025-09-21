<?php

defined('TYPO3') or die();

return [
    'ctrl' => [
        'title' => 'API Test',
        'label' => 'uid',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'delete' => 'deleted',
        'versioningWS' => true,
        'rootLevel' => 0,
        'hideTable' => false,
        'enablecolumns' => [],
        'iconfile' => 'EXT:nnrestapi/Resources/Public/Icons/tx_nnrestapi_domain_model_apitest.svg',
    ],
    'columns' => [
        'tstamp' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'crdate' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        'pid' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        // Eigene Felder hier ergänzen, z. B.
        'title' => [
            'label' => 'Title',
            'config' => [
                'type' => 'input',
                'eval' => 'trim',
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => 'title',
        ],
    ],
];
