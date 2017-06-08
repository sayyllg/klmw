<?php
namespace Ehr\Db;

use Zend\Db\TableGateway\TableGateway;
class DbTable extends TableGateway
{
	public $_prefix = '';

	/**
	 * @brief 构造函数
	 *
	 */
	public function __construct($table,$adapter)
	{
		parent::__construct($table,$adapter);
	}
}
