<?php

namespace Nng\Nnrestapi\Annotations;

/**
 * # Api\IncludeHidden
 * 
 * Enable retrieving of hidden records and relations from Database.
 * 
 * This makes an Endpoint behave like the Typo3 Backend: Hidden records
 * and records with `fe_group` or `starttime/endtime`-restrictions will
 * be returned to frontend.
 *  
 * ```
 * | -------------------------------------------------------|-------------------------------------------------------|
 * | annotation							    				| description						                    |
 * | -------------------------------------------------------|-------------------------------------------------------|
 * | @Api\IncludeHidden()				    				| all entries with hidden = 1 will be retrieved		    |
 * | @Api\IncludeHidden("*")								| same as "*"						                    |
 * | @Api\IncludeHidden("my_table")							| only entries from table "my_table" will be affected	|
 * | @Api\IncludeHidden("Nng\Apitest\Domain\Model\Entry")	| you can also use the model name instead				|
 * | @Api\IncludeHidden({"tt_content", "my_table"})			| only entries from given tables will be affected	    |
 * | -------------------------------------------------------|-------------------------------------------------------|
 * ```
 * 
 * Making hidden records visible in the frontend is not trivial.
 * Extensive testing might still be required.
 * 
 * We are using a combination of Xclasses, QuerySettings and visibiliy-aspects:
 * 
 * ## Xclasses
 * 
 * Are registered in the `ext_localconf.php` of this extension:
 * 
 * ### `Nng\Nnrestapi\Xclass\HiddenRestriction`
 * 
 * - Xclasses `TYPO3\CMS\Extbase\Persistence\Generic\QuerySettings`
 * - Needed to override HiddenRestrictions for relations, e.g. `sys_file_reference`
 * 
 * ### `Nng\Nnrestapi\Xclass\QueryFactory` 
 * 
 * - Xclasses `TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction`
 * - Needed to override HiddenRestrictions für extension repositories,
 *   e.g. when the user wants to call `->findAll()` on a repository
 * 
 * ## Context: visibility aspect
 * 
 * - Sets the Aspect: `visibility` of `TYPO3\CMS\Core\Context\Context`
 * - Called in the `ApiController` via `\nn\t3::Tsfe()->includeHiddenRecords(true, true);`
 *   just before the endpoint is called
 * - allows retriving hidden records like `tt_content` or `pages`
 * 
 * @Annotation
 */
class IncludeHidden
{
	public $value;

	public function __construct( $arr ) {
		if (empty($arr)) {
			$arr['value'] = '*';
		}
		$value = is_array( $arr['value'] ) ? $arr['value'] : [$arr['value']];
		$this->value = $value;
	}

	public function mergeDataForEndpoint( &$data ) {
		$data['includeHidden'] = $this->value;
	}
}