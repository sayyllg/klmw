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

			$params = array(
	    		'p'     		=> empty($data['p']) ? 1 : $data['p'],
	    		's'     		=> empty($data['s']) ? 20 : $data['s'],
	    		'mobile'   		=> $data['mobile']
	    	);

			$res = $this->_model->getPushList($params);
			echo json_encode($res);
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
