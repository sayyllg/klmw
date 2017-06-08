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
	use Api\Model\PushModel;
	
	class PushController extends ApiController {

		private $_model = NULL;


		/**
		 * @brief 
		 */
		public function listAction() {
			
			$this->_model = new PushModel();

			$data = $this->getSubmitData();

			$res = $this->_model->getPushList($data['mobile']);
			echo json_encode(array(
				'code' => 0,
				'data' => $res,
				'sysTime' => time()
			));
			exit;
		}


		public function saveAction() {
			
			$this->_model = new PushModel();

			$data = $this->getSubmitData();
			$res = $this->_model->savePush($data);

			echo json_encode(array(
				'code' => 0,
				'data' => $res,
				'sysTime' => time()
			));
			exit;
		}

		
	}
