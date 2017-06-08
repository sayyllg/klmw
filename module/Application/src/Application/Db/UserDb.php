<?php
namespace Application\Db;

use Application\Db\BaseDb;

class UserDb extends BaseDb
{

	public function __construct($table)
	{
		parent::__construct($table);
	}

}