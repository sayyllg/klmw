<?php
	
	/**************************************************
	* @brief     
	* @date      2016-8
	* @author  
	* @version   1.0
	* @copyright Immortal bird Team
	***************************************************/

	namespace Api\Controller;
	use Api\Controller\ApiController;
	use Zend\View\Model\ViewModel;
	use Api\Model\LgModel;
	use Api\Model\UserModel;
	use Api\Model\PushModel;
	
	class LgController extends ApiController {

		private $_model = NULL;

		/**
		 * @brief 
		 */
		public function lgAction() {
			$this->_model = new LgModel();
			$this->_user_model = new UserModel();
			$this->_push_model = new PushModel();
			//获取数据
			$data 	= $this -> getSubmitData();

			if(!is_array($data['body_params'])){
				$data['body_params'] = json_decode($data['body_params'],true);
			}
			
			if(strlen($data['phone_num']) == 14){
				$data['phone_num'] = substr($data['phone_num'], 3, 14);
			}

   			$redisData = $this->redis->get($data['phone_num']);

   			if($redisData){
   				$redisData = json_decode($redisData, true);
   			}else{
   				$redisData = [];
   			}
			$res  	= $this->_model -> save($data);

			$users = $this->_user_model->getUserInfo($data['phone_num']);

			$low = $users[0]['heart_sit']  -  $users[0]['heart_sit'] * 0.2 ;

			$high = $users[0]['heart_sit']  +  $users[0]['heart_sit'] * 0.2 ;
			if($data['body_params'][0]['steps'] > 80 && !array_key_exists('err_times', $redisData)){
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));
				exit;
			}else{
				if(($data['body_params'][0]['hearts'] == 0 &&  !array_key_exists('err_times', $redisData)) ||  ($data['body_params'][0]['hearts'] == 0 &&  array_key_exists('err_times', $redisData) && $redisData['err_times']<7 ) ){
					echo json_encode(array(
						"Success" => true,
						"Code" => 1,
						"Result" => "",
						"Error"=> ""
					));
					exit;

				}else{
					if($data['body_params'][0]['hearts'] <  $low  ||  $data['body_params'][0]['hearts'] > $high){
							$redisData['times'] = !array_key_exists('times', $redisData) ? 1 : $redisData['times']+1;
							$redisData['err_times'] = !array_key_exists('err_times', $redisData) ? 1 : $redisData['err_times']+1;
							$this->redis->set($data['phone_num'], json_encode($redisData));
							$this->checkHealthy($data, $redisData);
							exit;

					}else{


						if(!array_key_exists('times', $redisData)){
							echo json_encode(array(
								"Success" => true,
								"Code" => 1,
								"Result" => "",
								"Error"=> ""
							));

							exit;

						}else{
							$redisData['times'] = !array_key_exists('times', $redisData) ? 0 : $redisData['times']+1;
							$this->redis->set($data['phone_num'], json_encode($redisData));
							$this->checkHealthy($data, $redisData);
							exit;
						}
						

					}




				}




				exit;

			}



		}


		public function checkHealthy($data, $redisData){

			if($redisData['times'] > 10 && $redisData['err_times']>=7){

				$bindphone = $this->_user_model->getBindPhone($data['phone_num']);
				$mobilesstr = '';
				foreach ($bindphone as $key => $value) {
					$mobilesstr .= "'".$value['bindphone']."',";
				}
				$mobilesstr = rtrim($mobilesstr, ",");
				$channel_users = $this->_user_model->getChannelids($mobilesstr);
				$channel_ids = [];
				foreach ($channel_users  as $key => $value) {
					if($value['channel_id'] != ''){
						$channel_ids[] = $value['channel_id'];
					}
				}
				$this->_push_model->pushBatchMsg($channel_ids, $data['phone_num'], $channel_users);
				$this->redis->delete($data['phone_num']);
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));

			}else if($redisData['times'] > 10 && $redisData['err_times'] < 7){
				$this->redis->delete($data['phone_num']);
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));
			}else{
				echo json_encode(array(
					"Success" => true,
					"Code" => 2,
					"Result" => "",
					"Error"=> ""
				));

				exit;


			}


		}


		/**
		 * @brief 获取列表
		 */
		public function listAction() {
			
			$this->_model = new LgModel();
			//获取数据
			$access_token =  $this->getSubmitData('access_token');

			if(empty($access_token)){
				echo json_encode(array(
					'Code' => '0',
					'msg'  => 'access_token认证失败'
				));
				exit;
			};

			$redisData = $this->redis->get($access_token);	

			if($redisData == false){
				echo json_encode(array(
					'Code' => '0',
					'msg'  => 'access_token认证失败'
				));
				exit;
			};

			$redisData = json_decode($redisData, true);

			$params = array(
	    		'p'     		=> empty($this->getSubmitData('p')) ? 1 : $this->getSubmitData('p'),
	    		's'     		=> empty($this->getSubmitData('s')) ? 20 : $this->getSubmitData('s'),
	    		'mobile'   		=> empty($this->getSubmitData('mobile')) ? $redisData['mobile'] : $this->getSubmitData('mobile'),
	    	);

			$res  	= $this->_model -> getlist($params);
			if(!isset($res['errCode'])){
				$res['code'] = 0;
			}
			echo json_encode($res);exit();

			
		}

		/**
		 * @brief 获取列表
		 */
		public function timeAction() {
			
			$this->_model = new LgModel();
			//获取数据
			$access_token =  $this->getSubmitData('access_token');

			$redisData = $this->redis->get($access_token);

			if($redisData == false){
				echo json_encode(array(
					'Code' => '0',
					'msg'  => 'access_token认证失败'
				));
				exit;
			};	

			$redisData = json_decode($redisData, true);

			$start_time = $this->getSubmitData('start_time');
			$end_time = $this->getSubmitData('end_time');
			
			if(empty($start_time) || empty($end_time)){
				echo json_encode(array(
					'Code' => '0',
					'msg'  => '参数错误'
				));
				exit;
			}

			$params = array(
	    		'start_time'     		=> $start_time,
	    		'end_time'     		=> $end_time,
	    		'p'     		=> empty($this->getSubmitData('p')) ? 1 : $this->getSubmitData('p'),
	    		's'     		=> empty($this->getSubmitData('s')) ? 20 : $this->getSubmitData('s'),
	    		'mobile'   		=> empty($this->getSubmitData('mobile')) ? $redisData['mobile'] : $this->getSubmitData('mobile'),
	    	);

			$res  	= $this->_model -> getListByTime($params);
			if(!isset($res['errCode'])){
				$res['code'] = 0;
			}
			echo json_encode($res);exit();

			
		}

		

		
	}
