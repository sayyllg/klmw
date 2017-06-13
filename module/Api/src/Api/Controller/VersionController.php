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
	
	class VersionController extends ApiController {


		/**
		 * @brief 手表应用版本判断
		 */
		public function versionAction() {
			echo json_encode(array(
				'code' => 0,
				'varsion' => '1.0' 
			));
			exit;
		}


	}
