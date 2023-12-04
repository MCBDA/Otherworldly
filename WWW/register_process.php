<?php
//启动会话
session_start();
require_once'./common_use.php';
// 获取表单提交的数据
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 使用密码散列存储

// 连接到数据库
$db = new DB_Connector();
$conn = $db->get_conn();
// $conn = new mysqli(HOSTNAME, DATAUSERNAME, DATAPASSWORD, DATABASE);

// // 检查连接是否成功
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// 插入用户数据到数据库
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo "注册成功!<br />";
	echo "<a href='index.php'>返回登录界面</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
