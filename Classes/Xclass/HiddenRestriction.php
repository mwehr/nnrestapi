<?php

namespace Nng\Nnrestapi\Xclass;

use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction as BaseHiddenRestriction;

use TYPO3\CMS\Core\Database\Query\Expression\CompositeExpression;
use TYPO3\CMS\Core\Database\Query\Expression\ExpressionBuilder;
use TYPO3\CMS\Core\Http\ApplicationType;

/**
 * XCLASSes \TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction
 * Allows retrieving hidden records in a frontend context using the
 * `@Api\IncludeHidden("tablename")` annotation.
 * 
 * @see: `\Nng\Nnrestapi\Classes\Annotations\IncludeHidden.php` for more details
 * @see: https://bit.ly/3RMMZsk
 * 
 */
class HiddenRestriction extends BaseHiddenRestriction 
{
	/**
	 * 
     * @param array $queriedTables
     * @param ExpressionBuilder $expressionBuilder
     * @return CompositeExpression
	 */
	public function buildExpression(array $queriedTables, ExpressionBuilder $expressionBuilder): CompositeExpression
	{
		$isFrontend = \nn\rest::Environment()->isFrontend();
		$ignoreEnableFields = \nn\rest::Settings()->getQuerySettings('ignoreEnableFields') ?: [];
		$applyToAllTables = $ignoreEnableFields && in_array('*', $ignoreEnableFields);

		$constraints = [];
        foreach ($queriedTables as $tableAlias => $tableName) {

			// context MUST be frontend - and list of tables either contains `*` or the table is in the list
			if ($isFrontend && ($applyToAllTables || in_array($tableAlias, $ignoreEnableFields))) {
				continue;
			}
			
			// otherwise apply the default hidden restriction
            $hiddenFieldName = $GLOBALS['TCA'][$tableName]['ctrl']['enablecolumns']['disabled'] ?? null;
            if (!empty($hiddenFieldName)) {
                $constraints[] = $expressionBuilder->eq(
                    $tableAlias . '.' . $hiddenFieldName,
                    0
                );
            }
        }
        return $expressionBuilder->and(...$constraints);
	}

}