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
use Api\Db\LoginDb;

class LoginModel extends ApiModel
{
	private $_dblg	= NULL;
	
	
	/**
	 * @brief 初始化
	 */
	public function __construct( $user = NULL )
	{
		parent::__construct( $user );

		$this->_dblg 	= new LoginDb();
		
	}

	public function checkUser($mobile){

		return $this->_dblg->getUserInfo($mobile);

	}

	


}