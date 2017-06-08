<?php
/**
 * Api 
 *
 * @author 			yujl
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */
namespace Api\Model;
use Api\Model\ApiModel;
use Api\Db\PushDb;

class PushModel extends ApiModel
{
	private $_dblg	= NULL;
	
	
	/**
	 * @brief 初始化
	 */
	public function __construct( $user = NULL )
	{
		parent::__construct( $user );

		$this->_dblg 	= new PushDb();
		
	}

	public function getPushList($mobile){

		return $this->_dblg->getPushList($mobile);

	}

	public function savePush($data){

		// $this->pushMsg();

		return $this->_dblg->savePush($data);

	}


	public function pushMsg(){

		require_once 'sdk.php';

		$sdk = new \PushSDK();

		$channelId = '4166591451258461042';

		// message content.
		$message = array (
		    // 消息的标题.
		    'title' => 'Hi!',
		    // 消息内容 
		    'description' => "hello, this message from baidu push service." 
		);

		// 设置消息类型为 通知类型.
		$opts = array (
		    'msg_type' => 1 
		);

		// 向目标设备发送一条消息
		$rs = $sdk -> pushMsgToSingleDevice($channelId, $message, $opts);

		// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
		if($rs === false){
		   print_r($sdk->getLastErrorCode()); 
		   print_r($sdk->getLastErrorMsg()); 
		   exit;
		}else{
		    // 将打印出消息的id,发送时间等相关信息.
		    print_r($rs);
		}

		echo "done!";

	}


	public function pushBatchMsg($channel_ids, $mobile, $users){

		require_once 'sdk.php';

		$sdk = new \PushSDK();

		$channelIds = $channel_ids;

		// message content.
		$message = array (
		    // 消息的标题.
		    'title' => '健康提醒',
		    // 消息内容 
		    'description' => "您绑定的用户检测出心率异常，请及时联系查看。手机号：$mobile" 
		);

		// 设置消息类型为 通知类型.
		$opts = array (
		    'msg_type' => 1 
		);

		// 向目标设备发送一条消息
		$rs = $sdk -> pushBatchUniMsg($channelIds, $message, $opts);

		// 判断返回值,当发送失败时, $rs的结果为false, 可以通过getError来获得错误信息.
		if($rs === false){
		    $data['title'] = $message['title'];
		    $data['body'] = $message['description'];
		    $data['created_at'] = time();
			foreach ($users as $key => $value) {
				if($value['channel_id'] != ''){
					$data['mobile'] = $value['mobile'];
			   		$this->	savePush($data);
			   	}
		   }
		}else{
		    // 将打印出消息的id,发送时间等相关信息.
			$data['title'] = $message['title'];
		    $data['body'] = $message['description'];
		    $data['created_at'] = time();
		    $data['msg_id'] = $rs['msg_id'];
		    $data['send_time'] = $rs['send_time'];
		    foreach ($users as $key => $value) {
		    	if($value['channel_id'] != ''){
					$data['mobile'] = $value['mobile'];
		   			$this->	savePush($data);
		   		}
		   	}
		}


	}



}