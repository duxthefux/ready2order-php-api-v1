<?php
/**
 * Created by PhpStorm.
 * User: christopherfuchs
 * Date: 19.01.16
 * Time: 13:49
 */

namespace ready2order;


class ready2orderErrorException extends \ErrorException
{
	/** @var array */
	protected $data;

	public function __construct($message = "", $data = null)
	{
		if($data) {
			$this->data = $data;
		}

		parent::__construct($message);
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}



}