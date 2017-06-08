<?php
/**
 * PushModel
 *
 * @author 			yujl
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */
namespace Ehr\Model;

class PushModel{


	
	/**
	 * @brief 初始化
	 */
	public function __construct(){
		
		echo PUSH_SDK_HOME；exit;

		if(!defined('PUSH_SDK_HOME')){
		    define('PUSH_SDK_HOME', dirname(dirname(__FILE__)));
		}

		require_once PUSH_SDK_HOME . '/configure.php';
		require_once PUSH_SDK_HOME . '/sdk.php';
		
		
	}

}