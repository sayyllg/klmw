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
	use Api\Model\LoginModel;
	use Api\Model\UserModel;
	
	class LoginController extends ApiController {

		private $_model = NULL;


		/**
		 * @brief 
		 */
		public function loginAction() {
			
			$this->_model = new LoginModel();
			$this->_user_model = new UserModel();
			
			$data 	= $this -> getSubmitData();

			$users = $this->_model->checkUser($data['mobile']);

			if(count($users) == 1){

				if($users[0]['password'] == md5($data['pwd'])){

					$access_token = uniqid(16);
					$access['mobile'] = $data['mobile'];
					$this->redis->set($access_token, json_encode($access));
					if($users[0]['channel_id'] != $data['channel_id']){
						$re = $this->_user_model->updateChannnelId($users[0]['id'],$data['channel_id']);
					}
					echo json_encode(array(
						'code' => 0,
						'data' => array(
							'access_token' => $access_token
						),
						'sysTime' => time()
					));
				

				}else{

					echo json_encode(array(
						'code' => 1,
						'msg' => '密码错误' 
					));

				}	
			}else{

				echo json_encode(array(
					'code' => 1,
					'msg' => '不合法用户' 
				));
				
			}
			exit;
		}

		
	}
