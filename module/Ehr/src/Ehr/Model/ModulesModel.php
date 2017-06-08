<?php 
namespace Ehr\Model;
use Ehr\Db\UserDb;

class UserModel
{


	public function test()
	{
		$a = new UserDb();
		$list = $a->getDb();
		return $list;
	}
}