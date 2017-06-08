<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Ehr\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Ehr\Model\AccountModel;

class AccountController extends AbstractActionController{

    public function indexAction(){

        return new ViewModel();

    }

    public function loginAction(){
    	$account = $_POST;
    	$login = new AccountModel();
    	$userinfo = $login->login($account['mobile']);
    	if($userinfo[0]['password']  === md5($account['pwd'])){
    		session_start();
    		$_SESSION['name'] = $userinfo[0]['name'];
    		$_SESSION['mobile'] = $userinfo[0]['mobile'];
    		$_SESSION['machine'] = $userinfo[0]['machine'];
    		header("location: ".URL);
			exit;
    	}else{
    		header("location: ".URL."/account");
			exit;
    	}

    }


    public function logoutAction(){

    	$_SESSION = NULl;
    	header("location: ".URL."/account");
		exit;

    }

   
}
