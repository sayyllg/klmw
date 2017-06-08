<?php
	
	/**************************************************
	* @brief     
	* @date      2016-8
	* @author  
	* @version   1.0
	* @copyright Immortal bird Team
	***************************************************/

	namespace Ehr\Controller;
	use Ehr\Controller\EhrController;
	use Zend\View\Model\ViewModel;
	use Ehr\Model\LgModel;
	
	class LgController extends EhrController {

		private $_model = NULL;


		/**
		 * @brief 
		 */
		public function lgAction() {
			$this->_model = new LgModel();
			//获取数据
			$data 	= $this -> getSubmitData();
			//print_r($data);exit;
			$res  	= $this->_model -> save($data);
			
			//isset($res['err_code']) ? $this -> error($res) : $this -> succ(array('item' => array('rid' => $res)));
			echo json_encode(array(
					"Success" => true,
					"Code" => 0,
					"Result" => "",
					"Error"=> ""
				));exit();

			
		}

		/**
		 * @brief 获取列表
		 */
		public function listAction() {
			
			$this->_model = new LgModel();
			//获取数据
			$params = array(
	    		'p'     		=> $this->getSubmitData('p')     		?: 1,
	    		's'     		=> $this->getSubmitData('s')     		?: 20,
	    	);

			$res  	= $this->_model -> getlist($params);
			if(!isset($res['errCode'])){
				$res['code'] = 0;
			}
			echo json_encode($res);exit();

			
		}

		
	}
