<?php
//启动会话
session_start();
require_once'./common_use.php';

// 连接到数据库
$db = new DB_Connector();
$conn = $db->get_conn();
// 设置字符集为 utf8
mysqli_set_charset($conn, "utf8");

// 获取前端传来的角色名
$role_name = $_GET["selected_role"];

// 检查角色名是否为空
if (empty($role_name)) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => '请输入角色名'));
    exit;
}

// 使用 mysqli_real_escape_string 函数对用户输入的角色名称进行转义，防止 SQL 注入攻击
$role_name = mysqli_real_escape_string($conn, $role_name);

// 使用 mysqli_prepare 函数创建预处理语句，防止 SQL 注入攻击
$stmt = $conn->prepare("SELECT * FROM user_roles WHERE role_name = ?"); // 这是修改后的 SQL 语句，使用了预处理语句
$stmt->bind_param("s", $role_name); // s 表示字符串类型，这里把用户输入的角色名绑定到 SQL 语句中
$stmt->execute(); // 这是修改后的执行方式，使用了预处理语句
$result = $stmt->get_result(); // 这是获取结果的方式，使用了预处理语句

// 检查结果是否为空
if (mysqli_num_rows($result) == 0) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => '没有找到该角色'));
    exit;
}

// 定义一个数组，用来存储角色信息
$role_info = array();

// 遍历结果，将数据存入数组
while ($row = mysqli_fetch_assoc($result)) {
    $role_info["role_name"] = $row["role_name"];
    $role_info["level"] = $row["level"];
    $role_info["experience"] = $row["experience"];
    $role_info["health_points"] = $row["health_points"];
    $role_info["mana_points"] = $row["mana_points"];
    $role_info["gold"] = $row["gold"];
}

// 关闭数据库连接
mysqli_close($conn);

// 设置 Content-Type 头
header('Content-Type: application/json');

// 使用 json_encode 函数，将数组转换为 json 格式
$role_info_json = json_encode($role_info);

// 输出 json 数据到前端
echo $role_info_json;
?>
