<?php
/**
 * Api DemoController
 *
 * @author 			wangqi
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */

namespace Api\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\EventManager\EventManagerInterface;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;


class ApiController extends AbstractActionController
{

	/**
     * Requested method
     * @var string
     */
    protected $method;

	public function setEventManager(EventManagerInterface $events)
	{
		parent::setEventManager($events);
		$this->init();
	}

	/**
	 * @brief 初始化
	 *
	 */
	public function init()
	{

		header('Content-Type: text/html; charset=utf-8');

	}

	/**
	 * @brief 自动的restful识别
	 *
	 */
	public function autoRestFul()
	{
		$this->method = $this->getRequest()->getMethod();
		$action 	= strtolower($this->params()->fromRoute('action'));
		$method 	= ucfirst(strtolower($this->method));
		$func_name 	= $action.$method;
		if(method_exists($this , $func_name))
			$this->$func_name();
		else
			$this->notFoundAction();
	}

	/**
     * @brief 获取提交的数据
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getSubmitData($key = null, $default = null)
    {
    	if(!$this->method)
    		$this->method = $this->getRequest()->getMethod();

        switch ($this->method)
        {
            case 'GET':
            case 'DELETE':
                return $this->getParams($key , $default);
                break;
            case 'POST':
            case 'PUT':
            case 'PATCH':
                if($_SERVER['CONTENT_TYPE'] == 'application/json' || $_SERVER['CONTENT_TYPE'] == 'application/json; charset=UTF-8'){
                	if(file_get_contents('php://input')){
                		$data = json_decode(file_get_contents('php://input'), true);
                	}else{
						$data = json_decode($GLOBALS ["HTTP_RAW_POST_DATA"], true);
					}
				}else{
					$data = $this->request->getPost()->toArray();
				}
				if( $key != NULL ){
					return isset($data[$key]) ? $data[$key] : $default;
				}else{
					return $data;
				}
                break;
            default:
                return $default;
        }
    }

    /**
     * @brief 获取get参数
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getParams($key = null, $default = null)
    {
    	$data = $this->getRequest()->getQuery($key , $default);
    	if(null === $key)
    	{
    		return (array)$data;
    	}
    	return $data;
    }

    /**
     * @brief 获取phpinput值
     *
     * @param string $key
     * @param mixed $default Default value to use if key not found
     * @return mixed Returns null if key does not exist
     */
    public function getPhpInput ($key = null, $default = null)
    {
        $data = $this->getRequest()->getContent();
        $arr  = json_decode($data , true);
        ($arr === false) && ($arr = array());

        if(null === $key)
        {
            return $arr ? $arr : $data;
        }

        return (isset($arr[$key])) ? $arr[$key] : $default;
    }

	/**
	 * @brief 返回错误信息的报文
	 *
	 * @param $data   array
	 * @param $return bool
	 * @retval
	 */
	public function error ($data , $return = false)
	{
		$info = array(
			'err_code' => 10000,
			'err_memo' => '系统错误！',
			'request'  => $this->getRequest()->getUriString(),
		);

		if(is_array($data))
			$info = array_merge($info , $data);
		else
			$info['data'] = $data;

		if(!$return)
			echo Json::encode($info);
		else
			return $info;
	}

	/**
	 * @brief 返回正确信息的报文
	 *
	 * @param $data array
		<pre class="fragment">
		//列表数据格式
		Array
		(
			[list] => Array() //多条数据,2维数组列表
			[page] => Array
				(
					[pageno] => 1
					[pagesize] => 15
					[num] => 1
				)
		)

		单条信息数据库格式
		Array
		(
			[item] => Array() //单条数据,1维数组列表
		)
		</pre>
	 * @param $return bool or null
	 */
	public function succ ($data , $return = false)
	{
		$info = array(
			'code'     => 0,
			'data'     => $data,
			'msg'      => '',
			'systime'  => time()
		);

		if(!$return)
			echo Json::encode($info);
		else
			return $info;
	}

}
