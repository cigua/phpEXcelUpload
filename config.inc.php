<?php //require_once('checkpost.php'); ?>
<?php
header("content-type:text/html; charset=utf-8");
class DB{
//    public $servername = "120.24.86.50";
//    public $username = "root";
//    public $password = "123456";
//    public $dbname   = "hezuoshe";
//	 public $servername = "my0644154.xincache1.cn";
//    public $username = "my0644154";
//    public $password = "H9H7d2j5";
//    public $dbname   = "my0644154";
    public $servername = "bdm299127292.my3w.com";
    public $username = "bdm299127292";
    public $password = "149829622";
    public $dbname   = "bdm299127292_db";

    public function _query($sql){

        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->exec("set names UTF8");
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // 开始事务
            $conn->beginTransaction();
            // SQL 语句
            $res=$conn->exec("$sql");
            // 提交事务
            $conn->commit();
            return $res;

        }
        catch(PDOException $e)
        {
            // 如果执行失败回滚
            $conn->rollback();
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;

    }
    public function query($sql){
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->exec("set names UTF8");
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $conn->exec("set names UTF8");//设置数据库字符显示编码
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $result=$conn->query("$sql");
            return $result;

        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
}
//?>
