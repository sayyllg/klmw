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

class LgDb extends ApiDb {
	

	const HEART_INFO = 'heart_info';		// 
	const LOG 	  = 'log';		// 
	
	/**
	 * @brief 构造函数
	 *
	 * @retval null
	 */
	public function __construct(){
		parent::__construct();
	}

	/**
	 * @brief 保存信息
	 */
	/*public function saveLg( $data )
	{
		$tablename = 'yl_'.self::YUNGONG;
		//print_r($data);exit;
		$id = $this->insert( self::YUNGONG, $data );
		return $id;
	}*/	
	/* @brief 通过id获取信息
	* @param data
	* @param page
	**/
	public function getLgById($id) {
		$tablename = 'mw_'.self::HEART_INFO;
		$where     = "where id = $id";
		$sql  = "SELECT * from $tablename $where";
		return $this -> query($sql);

	}

	/* @brief  获取心率
	* @param data
	* @param page
	**/
	public function getHearts($client_sn) {
		$tablename = 'mw_'.self::HEART_INFO;
		$where     = "where client_sn = $client_sn";
		$sql  = "SELECT hearts from $tablename $where";
		return $this -> query($sql);

	}

	/* @brief  存入异常错误的数据
	* @param data
	* @param page
	**/
	public function addAbnormalLog($data) {
		$tablename = 'mw_'.self::LOG;
		$this->insert( $tablename, $data );
		
	}

	/* @brief  获取心率数据 
	* @param data
	* @param page
	**/
	public function getInfos($time) {
		$tablename = 'mw_'.self::HEART_INFO;
		$where     = "where created_at between $time and ".time() ;
		$sql  = "SELECT steps,hearts,created_at from $tablename $where";
		return $this -> query($sql);
	}


	/**
	 * @brief 保存
	 */
	public function saveLg( $data )
	{
		$tablename = 'mw_'.self::HEART_INFO;
		$sql = "INSERT INTO $tablename (phone_num,client_sn,lat,lng,steps,hearts,static_times,created_at) VALUES ";
		
		foreach ($data['body_params'] as $value) 
		{
			$sql.= "('".$data['phone_num']."','".$data['client_sn']."','".$data['lat']."','".$data['lng']."',".$value['steps'].",".$value['hearts'].",".$value['static_times'].",".time()."),";
		}
		
		$sql = substr($sql, 0, -1);	//去除最后的逗号 
		return $this->query( $sql );
	}

	/**
	 * @brief 获取列表
	 */
	public function getlist( $params )
	{
		$p 			= $params['p'];
		$s 			= $params['s'];
		$phone_num	= empty($params['mobile']) ? $_SESSION['mobile'] : $params['mobile'];

		$where = " where phone_num = '$phone_num'";
		$sql = "SELECT count(id) as counts FROM `mw_heart_info` $where ";
		
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
		$sql = "SELECT id,phone_num,client_sn,lat,lng,steps,hearts,static_times,created_at,upload_at  FROM `mw_heart_info` $where ".$order.$limit;
		
		$row   = $this->query($sql);
		if($row){
			return array(

				'page' => array( 
					'PageIndex'   	=> (int)$p,
					'PageSize' 		=> (int)$s,
					'TotalCount'    => (int)$rows,
					'HasNextPage' 	=> $HasNextPage,
				),
				'data' => $row,
				'code' => 0
			);

		}else{
			return array(

				'errCode' => 20002,
				'msg' => '获取数据失败' 
			);
		}
		
	}


	/**
	 * @brief 获取列表
	 */
	public function getListByTime( $params )
	{

		$start_time 		= $params['start_time'];
		$end_time 			= $params['end_time'];
		$p 					= $params['p'];
		$s 					= $params['s'];

		$phone_num	= empty($params['mobile']) ? $_SESSION['mobile'] : $params['mobile'];

		$where = " where phone_num = '$phone_num' and created_at>$start_time and created_at<$end_time";

		$sql = "SELECT count(id) as counts FROM `mw_heart_info` $where ";
		
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
		$sql = "SELECT id,phone_num,client_sn,lat,lng,steps,hearts,static_times,created_at,upload_at  FROM `mw_heart_info` $where ".$order.$limit;
		
		$row   = $this->query($sql);
		if($row){
			return array(

				'page' => array( 
					'PageIndex'   	=> (int)$p,
					'PageSize' 		=> (int)$s,
					'TotalCount'    => (int)$rows,
					'HasNextPage' 	=> $HasNextPage,
				),
				'data' => $row,
				'code' => 0
			);

		}else{
			return array(

				'errCode' => 20002,
				'msg' => '获取数据失败' 
			);
		}
		
	}

	public function getTestList( $params )
	{

		$code = $params['code'];
		$where = " where client_sn = '$code'";

		$limit = ' LIMIT 40';
		$order = " ORDER BY created_at DESC ";
		
		//信息查询
		$sql = "SELECT id,phone_num,client_sn,lat,lng,steps,hearts,static_times,created_at,upload_at  FROM `mw_heart_info` $where ".$order.$limit;
		$row   = $this->query($sql);

		return array
			(
				'page' => array( 
				),
				'data' => $row,
			);
	}

	public function createDate( $params ){
		$val = [];
		$hearts = ['65','66','67','68','69','70', '71','72','73','74'];
		$mobile = $params['mobile'];
		$code = $params['code'];
		for($start = $params['start']; $start < $params['end']; $start=$start+60){
			$index = rand(0,9);
			$heart = $hearts[$index];
			$val[] = "('$start', '$heart', '$mobile', '$code');";
		}
		$sql = '';
		foreach ($val as $key => $value) {
			$sql .= "Insert into mw_heart_info (`created_at`,`hearts`,`phone_num`,`client_sn`) VALUES ".$value;
		}
		$row   = $this->query($sql);
		var_dump($row);
		exit;
	}

}

