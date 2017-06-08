<?php 
namespace Application\Db;


use Application\Db\DbTable;
use Application\Db\LinkDb;
use Application\Model\Log;
class BaseDb
{
	protected static $db;
	protected static $adpter;
	protected static $sql;
	public function __construct($table)
	{
		$this->initDb($table);
	}


	//初始化数据库
	protected function initDb($table)
	{
		if (!$table) return false;
		if (empty(self::$adpter)){
			self::$adpter = LinkDb::linkDb();
		}
		if (empty(self::$db)){
			self::$db = new DbTable($table,self::$adpter);
		}	
		self::$sql = self::$db->getSql();
		self::$adpter->query('SET NAMES \'UTF8\'');
	}
	/**
	* 查询
	* @param   $where 
	* @return 得到的数组
    */
	public function select($where = null)
	{

		$resultSet = self::$db->select($where);

		$select = self::$sql->select();

		if ($where !== null)

		$select->where($where);
		
		$sql = self::$sql->getSqlStringForSqlObject($select);
		
		$result = $resultSet->toArray();

		$this->writeMysqlLog($sql);

		return $result;
	}


	/**
	* 添加
	* @param      $data array 添加的数据
	* @param $return true|false 
	* @return int false 影响行数 true 当前添加数组id
    */
	public function insert($data,$return=true)
	{
		if (!$data) return false ;


		$insert = self::$sql->insert();

		$insert->values($data);
		
		$affectedRows = self::$db->insertWith($insert);

		$sql = self::$sql->getSqlStringForSqlObject($insert);

		$this->writeMysqlLog($sql);

		if ($return)
		{
			return self::$db->lastInsertValue;
		}

		return $affectedRows;

	}	

    /**
     * 删除
     *
     * @param  $where string|array 
     * @return int  影响行数
     */
	public function delete ($where)
	{

		if (!$where) return false;

		$delete = self::$sql->delete();

		$delete->where($where);

		$affectedRows = self::$db->deleteWith($delete);

		$sql = self::$sql->getSqlStringForSqlObject($delete);

		$this->writeMysqlLog($sql);

		return $affectedRows;
	}

	/**
     * 更新
     *
     * @param  $set array 修改的数据 
     * @param  $where string|array 
     * @return int 影响行数
     */
	public function update ($set , $where = null)
	{
		$update = self::$sql->update();

		$update->set($set);

		if ($where !== null)
		{
			$update->where($where);
		}
		$affectedRows = self::$db->updateWith($update);

		$sql = self::$sql->getSqlStringForSqlObject($update);

		$this->writeMysqlLog($sql);

		return $affectedRows;
	}
	/**
	*执行sql语句
	*@param sql string 一条完整的sql语句
	*@param $mode execute|prepare 
	*@return array 
	*/
	public function query($sql,$mode = 'execute')
	{
		$queryType = substr(trim($sql),0,6);

		$result = self::$adpter->query($sql,$mode);

		$this->writeMysqlLog($sql);
		if ($mode == 'execute')
		{
			if ($queryType == 'select' )
			{
				return $result->toArray();
			}else
			{
				return $result->getAffectedRows();
			}
		}


         return $result;
	}
	//得到表前缀
	public function getPrefix()
	{
		return self::$db->_prefix;
	}
	//数据库对象
	public function getDb()
	{
		return self::$db;
	}
	//得到表名
	public function getTableName()
	{
		return self::$db->getTable();
	}

	//写log
	protected function writeMysqlLog($sql)
	{
		Log::writeLog('mysql',$sql);
	}

}