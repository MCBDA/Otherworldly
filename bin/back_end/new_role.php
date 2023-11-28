<?php
require_once'./common_use.php';
//启动会话
session_start();
//获取角色
$role_name = $_POST['role_name'];

// 创建连接
$db = new DB_Connector();
$conn = $db->get_conn();
// // 检测连接
// if ($conn->connect_error) {
//     die("连接失败: " . $conn->connect_error);
// } 
 
$sql = "INSERT INTO user_roles ()
VALUES ('John', 'Doe', 'john@example.com')";
 
if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
 
$conn->close();
?>