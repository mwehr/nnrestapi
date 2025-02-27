<?php

namespace Nng\Nnrestapi\Distiller;

class AbstractDistiller 
{
	/**
	 * Defines which fields/keys should be kept in the array.
	 * If empty, the complete array is returned.
	 * Will be overwritten by the individual distillers.
	 * 
	 * @var array
	 */
	public $keysToKeep = [];


	/**
	 * Called by ApiController before the data is returned.
	 * Central method for editing / distilling the data.
	 * 
	 * ```
	 * $this->processData( $assArr );
	 * $this->processData( [$assArr, $assArr, ...] );
	 * ```
	 * @return void
	 */
	public function processData( &$data = [] ) 
	{
		if (!$data) return;

		if (is_a($data, \TYPO3\CMS\Extbase\Persistence\Generic\QueryResult::class)) {
			$data = $data->toArray();
		} else if (is_a($data, \stdClass::class)) {
			$data = (array) $data;
		}
		if (is_object($data) || $this->isAssoc( $data )) {
			$this->process( $data );
			$this->pluck( $data, $this->keysToKeep );
		} else {
			foreach ($data as &$row) {
				$this->process( $row );
				$this->pluck( $row, $this->keysToKeep );
			}
		}
	}

	
	/**
	 * Checks whether the array is associative.
	 * ```
	 * $this->isAssoc( $arr );
	 * ```
	 * @return boolean
	 */
	public function isAssoc( $arr = [] ) 
	{
		if (is_object($arr)) return false;
		return array_keys($arr) !== range(0, count($arr) - 1);
	}
	
	
	/**
	 * Edit single element.
	 * This method is overridden by the individual distillers.
	 * ```
	 * $this->process( $assArr );
	 * ```
	 * @return void
	 */
	public function process( &$data = [] ) {}
	
	
	/**
     * Reduce array to single fields.
     * ```
     * // Simple array: Properties of given keys are returned
     * $this->pluck( $arr, ['uid', 'images', 'title'] );
	 * 
     * // Deep array: Properties of nested array are returned. Key is returned in dot-syntax
     * $this->pluck( $arr, ['uid', 'images', 'title', 'images.0.publicUrl'] );
     *
     * // Associative array: Get deep nested property and map it to a new key
     * $this->pluck( $arr, ['uid'=>'uid', 'publicUrl'=>'images.0.publicUrl'] );
     *
     * // Mixture is also possible
     * $this->pluck( $arr, ['uid', 'title', publicUrl'=>'images.0.publicUrl'] );
     * ```
     * @return void
     */
    public function pluck( &$data = [], $keysToKeep = [] ) 
	{
        if (!$keysToKeep) return;

		$objHelper = \nn\t3::Obj();
        $flatResult = [];

		$arr = $objHelper->toArray($data, 6);
		if (is_object($data)) {
			\Nng\Nnrestapi\Distiller\ModelDistiller::process( $data, $arr );
		}

        foreach ($keysToKeep as $key=>$path) {
            if (is_numeric($key)) {
				$key = $path;
            }
			$val = $this->getFromPath($path, $arr);
			if ($val !== null) {
				$flatResult[$key] = $val;
			}
        }
        $data = $flatResult;
    }


	/**
	 * Get value from nested array by dot-syntax, e.g. 'deep.nested.array'
	 * ```
	 * $this->getFromPath('a.b', ['a'=>['b'=>1]]);
	 * ```
	 * @return mixed
	 */
	public function getFromPath( $path = '', $setup = null ) {
		
		if (is_object($setup)) {
			$setup = (array) $setup;
		}

		$parts = explode('.', $path);

		$root = array_shift($parts);
		$plugin = array_shift($parts);

		$setup = $setup[$root] ?? null;
		if (!$plugin) return $setup;

		$setup = $setup[$plugin] ?? null;
		if (!count($parts)) return $setup;

		while (count($parts) > 0) {
			$part = array_shift($parts);
			if (count($parts) == 0) {
				return isset($setup[$part]) && is_array($setup[$part]) ? $setup[$part] : ($setup[$part] ?? null); 
			}
			$setup = $setup[$part];
		}

		return $setup;
	}

}