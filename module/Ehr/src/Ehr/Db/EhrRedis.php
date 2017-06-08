<?php 
/**
 * EhrRedis
 *
 * @author 			
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */

namespace Ehr\Db;
use Ehr\Db\LinkRedis;
use Ehr\Model\Log;
class EhrRedis
{
	protected static $db;
	protected static $adpter;

	/**
	 * @brief 构造函数
	 *
	 */
	public function __construct()
	{
		$this->initDb();
	}

	/**
	 * @brief 初始化数据库
	 *
	 */
	protected function initDb()
	{
		
		if (!self::$adpter)	self::$adpter = LinkDb::linkDb();
	}

	public function set(){

	}


	
}