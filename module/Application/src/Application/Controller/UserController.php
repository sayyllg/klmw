<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\Controller\BaseController;
use Application\Db\BaseDb;
use Application\Model\Log;
class UserController extends BaseController
{
    public function indexAction()
    {
       echo $this->getRequest()->getQuery();exit;
    }

    public function getDataAction()
     {	
		$b = new BaseDb('demo');
        $result = $b->query('select a.* from demo a left join aa b on a.id=b.id where a.id=7');
		var_dump($result);
        exit;
     }

}
