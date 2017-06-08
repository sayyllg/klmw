#命令使用方法 createModule.sh Ehr Text $1为应用名称 $2为controller名称
if [ $1 == '' ]; then
	echo '缺少参数'
else
	if [ -d "../module/$1" ]; then
		if [ $2 == '' ]; then 
			echo '缺少参数'
		else
			#创建Controller文件
			if [ -f "../module/$1/src/$1/Controller/$2Controller.php" ]; then
				echo "$2Controller.php文件已经存在！"
			else
				Controller="<?php\n\n\tnamespace $1\Controller;\n\tuse Zend\Mvc\Controller\AbstractActionController;\n\tuse Zend\View\Model\ViewModel;\n\n\tclass $2Controller extends AbstractActionController {\n\n\t\tpublic function indexAction() {\n\t\t\t\techo 'ok';exit;\n\t\t}\n\n\t}\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n?>"
				echo -e $Controller >> "../module/$1/src/$1/Controller/$2Controller.php"
				echo "$2Controller.php已创建！"
			fi	

			#创建Db文件
			if [ -f "../module/$1/src/$1/Db/$2Db.php" ]; then
				echo "$2DB.php文件已经存在！"
			else
				Db="<?php\n\n\tnamespace Ehr\Db;\n\tuse Ehr\Db\BaseDb;\n\n\tclass $2Db extends BaseDb {\n\t\tpublic function __construct($table){\n\t\t\tparent::__construct($table);\n\t\t}\n\t}\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n?>"
				echo -e $Db >> "../module/$1/src/$1/Db/$2Db.php"
				echo "$2Db.php已创建！"
			fi

			#创建Model文件
			if [ -f "../module/$1/src/$1/Model/$2Model.php" ]; then
				echo "$2Model.php文件已经存在！"
			else
				Model="<?php\n\n\tnamespace $1\Model;\n\tuse $1\Db\\$2Db;\n\n\tclass $2Model {\n\n\t\tpublic function index() {\n\t\t\t\$$2Db = new $2Db();\n\n\t\t}\n\n\t}\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n?>"
				echo -e $Model >> "../module/$1/src/$1/Model/$2Model.php"
				echo "$2Model.php已创建！"
			fi
			
			#注册控制器
			configs="'Ehr\Controller\\$2' => 'Ehr\Controller\\$2Controller',\nxxxxxx"
			sed -i '' "s/\/\/xxxxxx/'\\$1\\\\Controller\\\\$2' => '\\$1\\\\Controller\\\\$2Controller',\/\/xxxxxx/g" "../module/$1/config/module.config.php"
			# sed -i "s/\/\/xxxxxx/'\\$1\\\\Controller\\\\$2' => '\\$1\\\\Controller\\\\$2Controller',\r\n\/\/xxxxxx/g" "../module/$1/config/module.config.php"
		fi
	else
		echo "应用不存在，请运行createApp命令创建新应用！"
	fi
fi