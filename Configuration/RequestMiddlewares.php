<?php 

// @todo: TYPO3 v13 will probably remove these Middlewares
// check warnings in `EXT:typo3/cms-frontend/Configuration/RequestMiddlewares.php`

$pageResolverCallpoint = [
	'after' 	=> 'typo3/cms-frontend/prepare-tsfe-rendering',
	'before' 	=> 'typo3/cms-frontend/shortcut-and-mountpoint-redirect',
];

return [
	'frontend' => [

		// Parses the `PUT` and `DELETE` requests (usually not supported by PHP)
		'nnrestapi/requestparser' => [
			'target' => \Nng\Nnrestapi\Middleware\RequestParser::class,
			'before' => [
				'typo3/cms-frontend/timetracker',
			],
		],

		// Resolve the request, forward to ApiController
		'nnrestapi/cachehashfix' => [
			'target' => \Nng\Nnrestapi\Middleware\CacheHashFixer::class,
			'after' => [
				'typo3/cms-frontend/site',
			],
			'before' => [
				'typo3/cms-frontend/page-resolver',
			],
		],
		
		// Resolve the request, forward to ApiController
		'nnrestapi/resolver' => [
			'target' => \Nng\Nnrestapi\Middleware\PageResolver::class,
			'after' => [
				$pageResolverCallpoint['after'],
			],
			'before' => [
				$pageResolverCallpoint['before'],
			],
		]
	]
];