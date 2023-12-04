<?php
//启动会话
session_start();
require_once'./common_use.php';

// 连接到数据库
$db = new DB_Connector();
$conn = $db->get_conn();

// 获取用户的ID和名字
$user_id = $_SESSION["user_id"]; // 从表单中获取用户的ID
$name = $_POST["name"]; // 从表单中获取用户的名字

// 插入数据到数据库中的 role 表
$sql = "INSERT INTO user_roles (user_id,role_name) VALUES ( '$user_id','$name')"; // 构造 SQL 语句
$result = $conn->query($sql); // 执行 SQL 语句

if ($result) {
    echo "添加角色名字成功";
} else {
    echo "添加角色名字失败: " . $conn->error;
}
?>
