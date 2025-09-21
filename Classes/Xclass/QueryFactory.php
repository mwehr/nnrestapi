<?php

namespace Nng\Nnrestapi\Xclass;

use TYPO3\CMS\Extbase\Persistence\Generic\QueryFactory as BaseQueryFactory;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * XCLASSes \TYPO3\CMS\Extbase\Persistence\Generic\QueryFactory
 * 
 * Allows retrieving hidden records in a frontend context using the
 * `@Api\IncludeHidden("tablename")` annotation.
 * 
 * @see `\Nng\Nnrestapi\Annotations\IncludeHidden.php` for more details
 * 
 */
readonly class QueryFactory extends BaseQueryFactory {

	/**
	 * Creates a query object working on the given class name
	 *
	 * @param string $className The class name
	 * @return QueryInterface
	 */
	public function create($className): QueryInterface 
	{
		$query = parent::create($className);
		$isFrontend = \nn\rest::Environment()->isFrontend();
		$ignoreEnableFields = \nn\rest::Settings()->getQuerySettings('ignoreEnableFields') ?: [];
		$applyToAllTables = $ignoreEnableFields && in_array('*', $ignoreEnableFields);

		if (!$isFrontend || !$ignoreEnableFields) {
			return $query;
		}

		// convert `\Nng\Apitest\Domain\Model\Entry` to `tx_apitest_domain_model_entry`
		$tableName = \nn\t3::Db()->getTableNameForModel($className);
		if (!$applyToAllTables && !in_array($tableName, $ignoreEnableFields)) {
			return $query;
		}

		$querySettings = $query->getQuerySettings();
		$querySettings->setIgnoreEnableFields(true);
		$querySettings->setRespectStoragePage(false);
		$query->setQuerySettings($querySettings);

		return $query;
	}
}