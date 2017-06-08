<?php 
namespace Ehr\Model;

use Zend\Log\Logger;
use Zend\Log\Writer\Stream;
class Log
{
	public static function WriteLog($type='',$message='')
	{

		$logger = new Logger();

		$writer = new Stream(self::getPath($type)); 

		$logger->addWriter($writer);

		$logger->info($message);

	}

	protected static function getPath($type)
	{
		$logPath = '';
		switch ($type) {
			case 'mysql':
				$logPath = 'mysql.log';
				break;
			case 'login':
				$logPath = 'login.log';
				break;
			default:
				$logPath = 'error.log';
				break;
		}
		$logAllPath = WEB_PATH.'/../logs/'.$logPath;
		return $logAllPath;
	}


}