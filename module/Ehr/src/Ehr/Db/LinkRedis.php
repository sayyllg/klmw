<?php

//初始化adapter
namespace Ehr\Db;
use Zend\Db\Adapter\Adapter;
	
class LinkRedis{

	public static function LinkRedis(){
		
		include('config.php');
		$redis = new Redis();
        $link = $redis->connect('127.0.0.1', 6379);
        var_dump($link);
			
	}

}