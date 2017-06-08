<?php 
//初始化adapter
namespace Ehr\Db;


use Zend\Db\Adapter\Adapter;

class ModulesDb extends BaseDb{
  
  public static function modulesDb(){

    if (defined("DBHOST") && defined("DBUSER") && defined("DBPWD") && defined("DBNAME")){
       $drive = array(
            'driver'   => 'Pdo',
            'dsn'      => 'mysql:dbname='.DBNAME.';hostname='.DBHOST,
            'username' => DBUSER,
            'password' => DBPWD
            );
    }else{
      include('config.php');
       $drive = array(
            'driver'   => 'Pdo',
            'dsn'      => 'mysql:dbname='.DBNAME.';hostname='.DBHOST,
            'username' => DBUSER,
            'password' => DBPWD
            );
    }

    $this->adapter = new Adapter($drive);
    
    if ($this->adapter)    {
      return $this->adapter;
    }

    return false;
  }

  public test(){

  }

}