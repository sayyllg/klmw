<?php
/**
 * Api 
 *
 * @author 			lingxiao
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */
namespace Api\Model;
use Api\Model\ApiModel;
use Api\Db\LgDb;

class LgModel extends ApiModel
{
	private $_dblg	= NULL;
	
	
	/**
	 * @brief 初始化
	 */
	public function __construct( $user = NULL )
	{
		parent::__construct( $user );

		$this->_dblg 	= new LgDb();
		
	}


	/**
	 * @brief 
	 *
	 * @param $data
	 * @retval array
	 */
	public function save( $data ) 
	{
		if(empty($data) || !is_array($data))
			return $this->e( 50101 );

		$item = array();
		$item['phone_num'] 	= isset($data['phone_num']) ?  $data['phone_num'] : '';
		$item['client_sn'] 	= isset($data['client_sn']) ?  $data['client_sn'] : '';
		$item['lat'] 		= isset($data['lat']) ?  $data['lat'] : 0;
		$item['lng'] 		= isset($data['lng']) ?  $data['lng'] : 0;
		$item['created_at'] = time();
		
		//对body_params 数据处理
		$body_params = array();
		$i = 0;

		

		foreach ($data['body_params'] as $key => $val) {
			$body = array();
			$body['steps'] = $val['steps'];
			$body['hearts'] = $val['hearts'];
			$body['static_times'] = $val['static_times'];
			$body_params[] = $body;
			
		}
		$item['body_params'] = isset($data['body_params']) ?  $body_params : array();
		
		$this ->_dblg -> saveLg( $item );
		

		return true;
	}


	/**
	 * @brief 获取单条
	 *
	 * @param $id
	 * @retval array
	 */
	public function getLg( $id ) 
	{
		$id = trim($id);
		if(empty($id))
			return $this->e( 30101 );

		$row = $this->_db->getLgById( $id );
		return $row;
	}

	/**
	 * @brief 获取平均值
	 *
	 * @param $client_sn
	 * @retval array
	 */
	public function getAverage($client_sn)
	{
		$res = $this->_dblg->getHearts($client_sn);
		//求平均值，去除一个最大，一个最小
		$res = sort(array_column($res , 'hearts'));
		array_pop($res);
		array_shift($res);
		$average = array_sum($res)/count($res);

		return $average;
	}

	/**
	 * @brief 是否异常
	 *
	 * @param $data
	 * @retval array
	 */
	public function isAbnormal($data){
		$average = $this -> getAverage($data['client_sn']);

		//偏差范围可以写在配置文件，这里先写死，暂定30
		$res = $average - $data['hearts'];
		if (abs($res) > 30) {
			//存入异常log表
			$this ->_dblg -> addAbnormalLog($data);
			return false;
		}
		return true;
	}

	/**
	 * @brief 获取静坐心率 睡眠心率 运动心率 还有平常状态下的心率
	 *
	 * @param 
	 * @retval array
	 */	
	public function getStat() {
		/*//获取最近3天的心率数据
		$time = time() - 86400*3;
		$res = $this ->_dblg -> getInfos($time);
		//获取静坐心率hearts
		foreach ($res as $key => $value) {
			$h=date('G', $value['created_at']);
			if ($value['steps'] == 0 && $value['created_at']) {
				# code...
			}
		}*/
		return array(
			'sit_heart ' => 72,
			'sleep_heart ' => 75,
			'motion_heart ' => 65,
			'common_heart ' => 70,
			);
	}

	/**
	 * @brief 获取单条
	 *
	 * @param $id
	 * @retval array
	 */
	public function getlist( $params )
	{
		if(empty($params) || !is_array($params))
			return $this->e( 50101 );

		$res = $this ->_dblg -> getlist( $params );
		
		return $res;

	}


	public function getListByTime( $params )
	{
		if(empty($params) || !is_array($params))
			return $this->e( 50101 );

		$res = $this ->_dblg -> getListByTime( $params );
		
		return $res;

	}


	public function getTestList( $params ){

		return $this ->_dblg -> getTestList( $params );

	}

	public function createDate( $params ){

		return $this ->_dblg -> createDate( $params );

	}

	
	/**
	 * @brief 返回错误代码报文
	 *
	 * @param int $code
	 * @retval array
	 */
	public function e ( $code )
	{
		$error[50101] = '请求参数错误！';
		return isset($error[$code]) ? (array('err_code' => $code) + (is_string($error[$code]) ? array('err_memo'=>$error[$code]) : $error[$code])) : array('err_code'=>0 , 'err_memo'=>'');
	}

}