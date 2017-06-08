<?php 
/**
 * ApiDb
 *
 * @author 			
 * @copyright 		Immortal bird Team
 * @version 		1.0
 */

namespace Api\Db;
use Api\Db\DbTable;
use Api\Db\LinkDb;
use Api\Model\Log;
class ApiDb
{
	protected static $db;
	protected static $adpter;
	protected static $sql;
	private $_prefix = '';
	protected $_table ;

	/**
	 * @brief 构造函数
	 *
	 */
	public function __construct($table = '')
	{
		$this -> _table = $table;
		$this->_prefix = $this->getPrefix();
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


	/**
	 * @brief 链接表
	 *
	 */
	public function linkTable( $table )
	{
		if (!$table) return false;
		$table = $this->_prefix.$table;
		self::$db = new DbTable($table,self::$adpter);
		self::$sql = self::$db->getSql();
		self::$adpter->query('SET NAMES \'UTF8\'');
	}

	/**
	 * @brief 查询
	 *
	 * @param   $where 
	 * @return 	array
     */
	public function select( $table, $where = null)
	{
		$this->linkTable( $table );
		$resultSet = self::$db->select($where);
		$select = self::$sql->select();
		$result = array();
		if ($where !== null)
		{
			$select->where($where);
			$sql = self::$sql->getSqlStringForSqlObject($select);
			$result = $resultSet->toArray();
			$this->writeMysqlLog($sql);
		}
		return $result;
	}

	/**
	 * @brief 	添加
	 * @param 	$data array 添加的数据
	 * @param 	$return true|false 
	 * @return 	int false 影响行数 true 当前添加数组id
     */
	public function insert($table, $data, $return=true)
	{
		$this->linkTable( $table );
		if (!$data) return false ;
		$insert = self::$sql->insert();
		$insert->values($data);
		$affectedRows = self::$db->insertWith($insert);
		$sql = self::$sql->getSqlStringForSqlObject($insert);
		$this->writeMysqlLog($sql);
		if ($return)
			return self::$db->lastInsertValue;
		
		return $affectedRows;
	}	

    /**
     * @brief 删除
     *
     * @param  $where string|array 
     * @return int  影响行数
     */
	public function delete ( $table, $where )
	{
		$this->linkTable( $table );
		if (!$where) return false;
		$delete = self::$sql->delete();
		$delete->where($where);
		$affectedRows = self::$db->deleteWith($delete);
		$sql = self::$sql->getSqlStringForSqlObject($delete);
		$this->writeMysqlLog($sql);
		return $affectedRows;
	}

	/**
     * @brief  更新
     *
     * @param  $set array 修改的数据 
     * @param  $where string|array 
     * @return int 影响行数
     */
	public function update ($table, $set , $where = null)
	{
		$this->linkTable( $table );
		$update = self::$sql->update();
		$update->set($set);
		if ($where !== null)
			$update->where($where);
		
		$affectedRows = self::$db->updateWith($update);
		$sql = self::$sql->getSqlStringForSqlObject($update);
		$this->writeMysqlLog($sql);
		return $affectedRows;
	}


	/**
	 * @brief  执行sql语句
	 *
	 * @param sql string 一条完整的sql语句
	 * @param $mode execute|prepare 
	 * @return array 
	 */
	public function query($sql,$mode = 'execute')
	{
		$queryType = substr(trim($sql),0,6);
		$result = self::$adpter->query($sql,$mode);
		$this->writeMysqlLog($sql);
		if ($mode == 'execute')
		{

			if ( $queryType == 'select' or $queryType == 'SELECT' )
				return $result->toArray();
			else
				return $result->getAffectedRows();
		}

         return $result;
	}

	/**
	 * @brief 得到表前缀
	 *
	 */
	public function getPrefix()
	{
		if(!defined("TABLEPREFIX"))
			include_once('config.php');

		return TABLEPREFIX;
	}

	/**
	 * @brief 数据库对象
	 *
	 */
	public function getDb()
	{
		return self::$db;
	}

	/**
	 * @brief 获取表名
	 *
	 */
	public function getTableName()
	{
		return self::$db->getTable();
	}

	/**
	 * @brief 写log
	 *
	 */
	protected function writeMysqlLog($sql)
	{
		Log::writeLog('mysql',$sql);
	}

	/**
	 * @brief 根据数组获取 or sql 条件
	 *
	 * @param $data array()
	 * @param $key 	string
	 * @retval string
	 */
	public function getOrWhere( $data = array(), $key = 'id' )
	{
		$where = '';
		if(is_array($data) && !empty($data))
		{
			$where .= "($key = '";
			$where .= implode("' or $key = '", $data);
			$where .= "')";
		}
		
		return $where;
	}

	/**
	* @biref 搜索条件
	* @param param 
	* @param symbol 连接符
	**/
	public function _combineCondition($param, $symbol = 'AND') {

		if (empty($param)) {
			return array();
		} 
		$where = '';
		foreach ($param as $key => $value) {
			$where .= "$key = '$value'" . $symbol;
		}
		return rtrim($where, $symbol);
	}

}