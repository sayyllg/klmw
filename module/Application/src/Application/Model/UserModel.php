<?php 
namespace Application\Model;
use Application\Db\UserDb;

class UserModel
{


	public function test()
	{
		$a = new UserDb();
		$list = $a->getDb();
		return $list;
	}
}