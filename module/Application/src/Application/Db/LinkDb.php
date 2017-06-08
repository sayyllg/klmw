<?php 
//初始化adapter
namespace Application\Db;


use Zend\Db\Adapter\Adapter;

class LinkDb
{
  
  public static function linkDb()
  {
        if (defined("DBHOST") && defined("DBUSER") && defined("DBPWD") && defined("DBNAME"))
        {
           $drive = array(
                'driver'   => 'Pdo',
                'dsn'      => 'mysql:dbname='.DBNAME.';hostname='.DBHOST,
                'username' => DBUSER,
                'password' => DBPWD
                );
        }else
        {
          include('config.php');
           $drive = array(
                'driver'   => 'Pdo',
                'dsn'      => 'mysql:dbname='.DBNAME.';hostname='.DBHOST,
                'username' => DBUSER,
                'password' => DBPWD
                );
        }

      $adapter = new Adapter($drive);
      
      if ($adapter)
      {
        return $adapter;
      }

      return false;
  }

}