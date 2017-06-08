<?php
	
/**
 * Api AddresslistDb
 *
 * @author 			lingxiao
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */

namespace Api\Db;
use Api\Db\YlDb;

class UserDb extends ApiDb {
	

	const USERS 		= 'users';			// 用户表

	const BINDPHONE 		= 'bindphone';			// 用户表

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

	/**
	 * @brief 获取用户绑定手表list
	 *
	 * @retval id
	 */
	public function getBindPhone( $mobile )
	{
		return $this -> select( self::BINDPHONE, array('mobile' => $mobile) );
	}


	public function updateChannnelId( $id, $channel_id )
	{	
		$sql = "update users set channel_id='$channel_id' where id=$id";
		return $this -> query( $sql );
	}


	public function getChannelIds( $mobilesstr )
	{	

		$sql = "select * from users where mobile in ($mobilesstr)";
		return $this -> query( $sql );
	}

	

}

