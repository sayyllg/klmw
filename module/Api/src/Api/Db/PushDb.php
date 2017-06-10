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
	public function getPushList( $params )
	{	
		$p 			= $params['p'];
		$s 			= $params['s'];
		$mobile	= $params['mobile'];

		$where = " where mobile = '$mobile'";
		$sql = "SELECT count(id) as counts FROM `push` $where ";
		//分页计算
		$rows  = current(array_column($this->query($sql) , 'counts'));   //总记录条数
		$pages = ceil($rows / ($s ? $s : 20)); //总页数
		//
		if(($p < 0) || ($p > $pages - 1))
			$HasNextPage = false;
		else
			$HasNextPage = true;

		$limit = ' LIMIT ' . $s*($p-1) . ' , '. $s;
		$order = " ORDER BY created_at DESC ";		
		//信息查询
		$sql = "SELECT * FROM `push` $where ".$order.$limit;


		$row   = $this->query($sql);

		if(is_array($row)){
			return array(

				'page' => array( 
					'PageIndex'   	=> (int)$p,
					'PageSize' 		=> (int)$s,
					'TotalCount'    => (int)$rows,
					'HasNextPage' 	=> $HasNextPage,
				),
				'data' => $row,
				'Code' => 1
			);

		}else{
			return array(

				'Code' => 0,
				'msg' => '获取数据失败' 
			);
		}
	}


	public function savePush( $data )
	{	
		$data['created_at'] = time();
		$res = $this -> insert( self::PUSH, $data );
		return $res;
	}


	

}

