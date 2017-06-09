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

			$res  	= $this->_model -> save($data);

			$users = $this->_user_model->getUserInfo($data['phone_num']);

			$low = $users[0]['heart_sit']  -  $users[0]['heart_sit'] * 0.2 ;

			$high = $users[0]['heart_sit']  +  $users[0]['heart_sit'] * 0.2 ;

			session_start();
			if($data['body_params'][0]['steps'] > 80 && empty($_SESSION['times'])){
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));
				exit;
			}else{
				if(($data['body_params'][0]['hearts'] == 0 &&  empty($_SESSION['err_times'])) ||  ($data['body_params'][0]['hearts'] == 0 &&  !empty($_SESSION['err_times']) && $_SESSION['err_times']<7 ) ){
					echo json_encode(array(
						"Success" => true,
						"Code" => 1,
						"Result" => "",
						"Error"=> ""
					));
					exit;

				}else{
					if($data['body_params'][0]['hearts'] <  $low  ||  $data['body_params'][0]['hearts'] > $high){
							$_SESSION['times'] = empty($_SESSION['times']) &&  $_SESSION['times'] != 0 ? 0 : $_SESSION['times']+1;
							$_SESSION['err_times'] = empty($_SESSION['err_times']) &&  $_SESSION['err_times'] != 0 ? 0 : $_SESSION['err_times']+1;

							
							$this->checkHealthy($data);
							exit;

					}else{


						if(empty($_SESSION['times'])){
							echo json_encode(array(
								"Success" => true,
								"Code" => 1,
								"Result" => "",
								"Error"=> ""
							));

							exit;

						}else{
							$_SESSION['times'] = empty($_SESSION['times']) &&  $_SESSION['times'] != 0 ? 0 : $_SESSION['times']+1;
							
							$this->checkHealthy($data);
							exit;
						}
						

					}




				}




				exit;

			}



		}


		public function checkHealthy($data){

			if($_SESSION['times'] > 10 && $_SESSION['err_times']>=7){

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

				session_destroy();
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));

			}else if($_SESSION['times'] > 10 && $_SESSION['err_times'] < 7){
				session_destroy();
				echo json_encode(array(
					"Success" => true,
					"Code" => 1,
					"Result" => "",
					"Error"=> ""
				));
			}else{
				echo json_encode(array(
					"Success" => false,
					"Code" => 1,
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
			session_start();
			if(empty($_SESSION['mobile'])){
				echo json_encode(array(
					'errCode' => '20004',
					'msg'  => 'session失效'
				));
				exit;
			};	

			$params = array(
	    		'p'     		=> empty($this->getSubmitData('p')) ? 1 : $this->getSubmitData('p'),
	    		's'     		=> empty($this->getSubmitData('s')) ? 20 : $this->getSubmitData('s'),
	    		'mobile'   		=> empty($this->getSubmitData('mobile')) ? $_SESSION['mobile'] : $this->getSubmitData('mobile'),
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
			session_start();
			if(empty($_SESSION['mobile'])){
				echo json_encode(array(
					'errCode' => '20004',
					'msg'  => 'session失效'
				));
				exit;
			};	
			$start_time = $this->getSubmitData('start_time');
			$end_time = $this->getSubmitData('end_time');
			if(empty($start_time) || empty($end_time)){
				echo json_encode(array(
					'errCode' => '20005',
					'msg'  => '参数错误'
				));
				exit;
			}

			$params = array(
	    		'start_time'     		=> $start_time,
	    		'end_time'     		=> $end_time,
	    		'p'     		=> empty($this->getSubmitData('p')) ? 1 : $this->getSubmitData('p'),
	    		's'     		=> empty($this->getSubmitData('s')) ? 20 : $this->getSubmitData('s'),
	    		'mobile'   		=> empty($this->getSubmitData('mobile')) ? $_SESSION['mobile'] : $this->getSubmitData('mobile'),
	    	);

			$res  	= $this->_model -> getListByTime($params);
			if(!isset($res['errCode'])){
				$res['code'] = 0;
			}
			echo json_encode($res);exit();

			
		}

		

		
	}
