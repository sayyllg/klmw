<?php 
namespace Api\Model;
use Api\Db\UserDb;

class UserModel
{


	public function test()
	{
		$a = new UserDb();
		$list = $a->getDb();
		return $list;
	}
}