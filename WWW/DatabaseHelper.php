<?php
require_once './config.php';

class DatabaseHelper
{
    private $conn;
    
    public function 初始化()
    {
        $this->conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // 插入数据
    public function 插入($table, $data)
    {
		//$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        //第一种方式：直接传输SQL语句查询
        $result = $this->conn->query($sql);	//查询结果存储在 $result 变量中,返回的结果是一个对象,通常是 mysqli_result 对象。
        if ($result && $result->num_rows > 0) {
            return true;
        } else {
            return false;
        }
        
		//第二种方法,使用键值对进行处理
		// $columns = implode(', ', array_keys($data));
		// $values = "'" . implode("', '", array_values($data)) . "'";
		// $sql = "INSERT INTO $table ($columns) VALUES ($values)";
		// $result = $this->conn->query($sql);
		// if ($result && $result->num_rows > 0) {
		//     return true;
		// } else {
		//     return false;
		// }
        
        
        //第三种，对键值对进行预处理
        // $sql = "INSERT INTO $table (".implode(", ", array_keys($data)).") VALUES (".str_repeat("?, ", count($data)-1)."?)";
        // $stmt = $this->conn->prepare($sql);
        // if ($stmt) {
        //     $types = str_repeat("s", count($data));
        //     $stmt->bind_param($types, ...array_values($data));
                        
        //     if ($stmt->execute()) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }
        // return false;


    }
    
    // 更新数据
    public function 更新($table, $data, $条件)
    {
        $updateData = [];
        foreach ($data as $key => $value) {
            $updateData[] = "$key = '$value'";
        }
        $updateValues = implode(', ', $updateData);
        $sql = "UPDATE $table SET $updateValues WHERE $条件";
        return $this->conn->query($sql);
    }
    
    // 删除数据
    public function 删除($table, $条件)
    {
        $sql = "DELETE FROM $table WHERE $条件";
        return $this->conn->query($sql);
    }
    
    // 查询数据
    public function 查询($table, $条件 = "")
    {
        $sql = "SELECT * FROM $table";
        if (!empty($条件)) {
            $sql .= " WHERE $条件";
        }
        $result = $this->conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // 添加其他操作方法，如删除、查询和更新

    public function closeConnection()
    {
        $this->conn->close();
    }
}
