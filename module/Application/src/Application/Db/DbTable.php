<?php
namespace Application\Db;

use Zend\Db\TableGateway\TableGateway;
class DbTable extends TableGateway
{
	public $_prefix = '';
	public function __construct($table,$adapter)
	{
		parent::__construct($this->_prefix.$table,$adapter);
	}

	public function readPrefix()
	{
		if (defined("TABLEPREFIX"))
		{
			$this->_prefix = TABLEPREFIX;
		}
		else{
			include_oncs('config.php');
			$this->_prefix = TABLEPREFIX;
		}
	}
}

