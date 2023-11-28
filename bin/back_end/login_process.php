<?php
require_once'./common_use.php';

//启动会话
session_start();

// 获取表单提交的数据
$username = $_POST['username'];
$password = $_POST['password'];

$db = new DB_Connector();
$conn = $db->get_conn();

// 连接到数据库
// $conn = new mysqli(HOSTNAME, DATAUSERNAME, DATAPASSWORD, DATABASE);

// // 检查连接是否成功
// if ($conn->connect_error) {
//     die("数据库连接失败: " . $conn->connect_error);
// } else {
//     echo "Connection successful!";
// }

// 查询用户数据
$sql = "SELECT user_id, username, password FROM users WHERE username = ?";	//这是一个SQL查询语句，它选择了名为 users 的数据库表中的 id、username 和 password 列，其中 username 列的值必须与后面绑定的参数匹配（由 ? 表示，稍后通过 bind_param 绑定）。这个查询的目的是查找具有特定用户名的用户。
$stmt = $conn->prepare($sql);	//使用prepare方法创建了一个预处理语句（prepared statement）。预处理语句是一种安全的执行SQL查询的方式，可以防止SQL注入攻击。
$stmt->bind_param("s", $username);	//这一行将参数绑定到预处理语句中。在这里，我们将一个字符串参数（"s" 表示字符串）绑定到查询中的 ? 位置。这个参数是 $username 变量的值，它将在执行查询时替换 ?。
$stmt->execute();	//执行预处理语句，将之前绑定的参数传递给查询，然后执行查询。这会执行数据库中的实际查询并返回结果。
$stmt->store_result();	//存储查询结果以供后续使用。store_result 方法将查询结果缓存到PHP内存中，以便你可以使用 $stmt->fetch() 等方法来获取查询结果的行数和数据。

if ($stmt->num_rows === 1) {

    $stmt->bind_result($user_id, $username, $hashed_password);	//这行代码用于将查询结果的列绑定到指定的变量上。在这里，我们绑定了三个变量：$id、$username 和 $hashed_password。这意味着当 fetch 方法执行后，查询结果的每一行都会将这些列的值分别赋给这些变量。
	$stmt->fetch();
	// echo "用户密码：$password<br>";
	// echo "服务器用户密码：$hashed_password<br>";
	// while ($stmt->fetch()) {
	//     echo "ID: $id, Username: $username, Password: $hashed_password<br>";
	// }
    // 验证密码
    if (password_verify($password, $hashed_password)) {
        echo "登录成功, " . $username;
		//生成令牌TOKEN
		
		//登录成功后保存好用户ID，$_SESSION是PHP中用于处理会话（session）数据的全局数组
		$_SESSION['user_id'] = $user_id;
		//重定向到用户角色界面
		header("Location: roleselection.php");
		// 确保页面不再继续执行
		exit;
    } else {
        echo "登录失败，请查看你的账号密码.";
    }
} else {
    echo "用户不存在，请注册.";
}

  

$stmt->close();
$conn->close();
?>
