<?php
/**
 * Ehr UserModel
 *
 * @author 			lingxiao
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */

namespace Ehr\Db;
use Ehr\Db\EhrDb;

class AccountDb extends EhrDb {
	
	const USERS 		= 'users';			// 用户表

	/**
	 * @brief 构造函数
	 *
	 * @retval null
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * @brief 获取用户信息
	 *
	 * @retval id
	 */
	public function getUserInfo( $mobile )
	{
		return $this -> select( self::USERS, array('mobile' => $mobile) );
	}

}

