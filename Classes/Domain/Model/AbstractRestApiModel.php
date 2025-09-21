<?php
namespace Nng\Nnrestapi\Domain\Model;

/**
 * A base model that can be extended in your own extensions. 
 * 
 * Use in your own Model like this:
 * ```
 * class MyModel extends \Nng\Nnrestapi\Domain\Model\AbstractRestApiModel {}
 * ```
 * 
 * (!!) Important:
 * If you can't access `tstamp` or `crdate`, make sure, you have these fields defined in
 * the TCA. Otherwise they will not get mapped!
 * 
 * ```
 * 'tstamp' => [
 * 	'label' => 'tstamp',
 * 	'config' => [
 * 		'type' => 'passthrough',
 * 	]
 * ],
 * ```
 * 
 */
abstract class AbstractRestApiModel extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{
	/**
	 * @var ?int
	 */
	protected ?int $pid = null;

	/**
	 * @var ?int
	 */
	protected ?int $tstamp = null;

	/**
	 * @var ?int
	 */
	protected ?int $crdate = null;

	/**
	 * @return  ?int
	 */
	public function getPid(): ?int {
		return $this->pid;
	}

	/**
	 * @param   ?int  $pid  
	 * @return  self
	 */
	public function setPid(?int $pid):void {
		$this->pid = $pid;
	}

	/**
	 * Only accessible if also defined in TCA! (see above)
	 * @return  ?int
	 */
	public function getTstamp(): ?int {
		return $this->tstamp;
	}

	/**
	 * @param   ?int  $tstamp  
	 * @return  self
	 */
	public function setTstamp(?int $tstamp): self {
		$this->tstamp = $tstamp;
		return $this;
	}

	/**
	 * Only accessible if also defined in TCA! (see above)
	 * @return  ?int
	 */
	public function getCrdate(): ?int {
		return $this->crdate;
	}

	/**
	 * @param   ?int  $crdate  
	 * @return  self
	 */
	public function setCrdate(?int $crdate): self {
		$this->crdate = $crdate;
		return $this;
	}

	/**
	 * @return  ?int
	 */
	public function getL10nUid(): ?int {
		return $this->_localizedUid;
	}

	/**
	 * @return  ?int
	 */
	public function getSysLanguageUid(): ?int {
		return $this->_languageUid;
	}
	
	/**
	 * @param   mixed  $sysLanguageUid
	 * @return  self
	 */
	public function setSysLanguageUid(mixed $sysLanguageUid = ''): self {
		$this->_setProperty( '_languageUid', $sysLanguageUid );
		return $this;
	}

}
