<?php 
require_once'lianjie.php';
	class DB_Connector
	{
		private $conn;
		public function __construct() {
			// 连接到数据库
			$this->conn = new mysqli(HOSTNAME, DATAUSERNAME, DATAPASSWORD, DATABASE);
		  
			// 检查连接是否成功
			if ($this->conn->connect_error) {
			  die("数据库连接失败: " . $this->conn->connect_error);
			}
			 
		  }
		  public function get_conn() {
			// 返回数据库连接对象
			return $this->conn;
		  }
		//   public function __destruct() {
		// 	// 关闭数据库连接对象
		// 	$this->conn->close();
		//   }
		  
		  
		//上面是数据库连接
		

	}
	
?>