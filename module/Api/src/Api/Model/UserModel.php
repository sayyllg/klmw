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
use Api\Db\UserDb;

class UserModel extends ApiModel
{
	private $_dblg	= NULL;
	
	
	/**
	 * @brief 初始化
	 */
	public function __construct( $user = NULL )
	{
		parent::__construct( $user );

		$this->_dblg 	= new UserDb();
		
	}

	public function getUserInfo($mobile){

		return $this->_dblg->getUserInfo($mobile);

	}


	public function getBindPhone($mobile){

		return $this->_dblg->getBindPhone($mobile);

	}

	public function updateChannnelId($id, $channel_id){
		
		return $this->_dblg->updateChannnelId($id, $channel_id);
	}


	public function getChannelids($mobilesstr){
		
		return $this->_dblg->getChannelids($mobilesstr);
	}

}