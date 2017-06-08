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

class PushDb extends ApiDb {
	

	const PUSH		= 'push';			// 用户表

	/**
	 * @brief 构造函数
	 *
	 * @retval null
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * @brief 获取手机用户的消息推送
	 *
	 * @retval id
	 */
	public function getPushList( $mobile )
	{	
		$res = $this -> select( self::PUSH, array('mobile' => $mobile) );
		return $res;
	}


	public function savePush( $data )
	{	
		$data['created_at'] = time();
		$res = $this -> insert( self::PUSH, $data );
		return $res;
	}


	

}

