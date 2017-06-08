<?php 
namespace Ehr\Model;
use Ehr\Db\AccountDb;

class AccountModel
{

	public function login($mobile){

		$login = new AccountDb();
		$userinfo = $login->getUserInfo($mobile);
		return $userinfo;

	}
}