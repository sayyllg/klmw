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
	use Api\Model\UserModel;
	
	class UserController extends ApiController {

		private $_model = NULL;


		/**
		 * @brief 获取绑定用户列表
		 */
		public function bindAction() {
			
			$this->_model = new UserModel();

			$data = $this->getSubmitData();

			$res = $this->_model->getBindPhone($data['mobile']);

			echo json_encode(array(
				'code' => 0,
				'data' => $res,
				'sysTime' => time()
			));
			exit;
		}


		/**
		 * @brief 获取用户相信信息
		 */
		public function infoAction() {
			
			$this->_model = new UserModel();

			$data = $this->getSubmitData();

			$res = $this->_model->getUserinfo($data['mobile']);

			echo json_encode(array(
				'code' => 0,
				'data' => $res[0],
				'sysTime' => time()
			));
			exit;
		}

		
	}
