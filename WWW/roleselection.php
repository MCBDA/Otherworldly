<?php
//启动会话
session_start();
require_once'./common_use.php';

// 连接到数据库
$db = new DB_Connector();
$conn = $db->get_conn();

// 获取当前登录用户的角色信息
$user_id = $_SESSION['user_id']; // 假设用户ID存储在SESSION中

// 获取用户选择的角色名称
$selected_role = $_GET["selected_role"]; // 假设用户选择的角色名称存储在GET中

// 验证用户输入的角色名称
$selected_role = filter_input(INPUT_GET, "selected_role", FILTER_SANITIZE_STRING);

//使用mysqli_real_escape_string函数对用户输入的角色名称进行转义，防止SQL注入攻击
$selected_role = mysqli_real_escape_string($conn, $selected_role);

$sql = "SELECT * FROM user_roles WHERE user_id = '$user_id' AND role_name = '$selected_role'";


$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $role_name = $row["role_name"];
    $level = $row["level"];
    $experience = $row["experience"];
    $health_points = $row["health_points"];
    $mana_points = $row["mana_points"];
    $gold = $row["gold"];
    
    // 使用json_encode函数将数据转换为json格式，然后使用echo函数输出到网页上，方便前端使用jQuery的ajax方法接收和处理数据
    $data = array(
        "role_name" => $role_name,
        "level" => $level,
        "experience" => $experience,
        "health_points" => $health_points,
        "mana_points" => $mana_points,
        "gold" => $gold
    );
    
    echo json_encode($data);
// }else {
//     //使用mysqli_error函数获取数据库的错误信息，然后使用echo函数输出到网页上，方便前端使用jQuery的ajax方法接收和处理错误信息
//     $error = mysqli_error($conn);
//     echo "找不到用户的角色信息，错误原因：$error";
}
?>
<!-- 选择角色 -->
<?php
//启动会话
// session_start();
// require_once'./common_use.php';

// // 连接到数据库
// $db = new DB_Connector();
// $conn = $db->get_conn();

// $user_id = $_SESSION['user_id'];

// // 查询用户所注册过的角色
// $sql = "SELECT role_name FROM user_roles WHERE user_id = ?"; // 构造 SQL 语句
// $stmt = mysqli_prepare($conn, $sql); // 创建预处理语句
// mysqli_stmt_bind_param($stmt, "i", $user_id); // 绑定参数
// mysqli_stmt_execute($stmt); // 执行语句
// $result = mysqli_stmt_get_result($stmt); // 获取结果
// //使用 while 循环遍历结果，使用 echo 函数输出每个角色名称到网页上，方便前端使用 jQuery 的 html 方法接收和显示数据
// while ($row = mysqli_fetch_assoc($result)) { // 遍历结果
//     $role_name = $row["role_name"]; // 获取角色名称
//     echo $role_name . "\n"; // 输出角色名称
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>选择角色</title>
    <style type="text/css">
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        h1{
            text-align: center;
            color: #3498db;
        }
        .character-card {
            background-color: #3498db;
            color: #fff;
            border: 1px solid #1f73af;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            flex-direction: column;
        }

        .character-card:hover {
            background-color: #542653;
        }
        .character-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .character-name {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .character-level-gold {
            font-size: 0.9rem;
            color: #ecf0f1;
        }
        .character-map{
            font-size: 1rem;
            margin-top: 10px;
        }
        .character-level-exp {
            font-size: 0.9rem;
            margin-top: 10px;
        }
        .register-card {
            background-color: #e67e22;
            color: #fff;
            border: 1px solid #b8541f;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-card:hover{
            background-color: #542653;
        }

    </style>
</head>
<body>
    <div class="container">
    <h1>请选择您的角色</h1>
    
        <div>您当前的角色信息：</div>
        <div id="role-info"></div>
        <div class="register-card" onclick="redirectToRegistration()">
            <h2>注册角色</h2>
            <p>创建全新的游戏角色</p>
        </div>

             <label for="selected_role">请选择一个角色：</label>
                <!-- <select name="selected_role" id="selected_role">
                <?php
                // while ($row = mysqli_fetch_assoc($result)) { // 遍历结果
                //     $role_name = $row["role_name"]; // 获取角色名称
                //     echo "<option value='$role_name'>$role_name</option>"; // 输出option标签
                // }
                ?> 
             </select>  -->
             <select name="selected_role" id="selected_role">
                <?php
                // 重新查询用户所注册过的角色
                $sql = "SELECT role_name FROM user_roles WHERE user_id = ?"; // 构造 SQL 语句
                $stmt = mysqli_prepare($conn, $sql); // 创建预处理语句
                mysqli_stmt_bind_param($stmt, "i", $user_id); // 绑定参数
                mysqli_stmt_execute($stmt); // 执行语句
                $result = mysqli_stmt_get_result($stmt); // 获取结果
                while ($row = mysqli_fetch_assoc($result)) { // 遍历结果
                    $role_name = $row["role_name"]; // 获取角色名称
                    echo "<option value='$role_name'>$role_name</option>"; // 输出option标签
                }
                ?>
            </select>

        <br>
            <input type="submit" id="select_role" value="选择角色">
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
                // 定义一个函数，用来向后端发送请求，获取最新的角色信息
                function getRoleInfo() {
            // 获取用户选择的角色名
            var role_name = $("#selected_role").val();
            // 使用 jQuery 的 ajax 方法，向后端发送请求
            $.ajax({
                url: "get_role_info.php", // 后端处理脚本的地址
                type: "GET", // 请求的方式
                data: {selected_role: role_name}, // 请求的数据，这里是角色名
                dataType: "json", // 响应的数据类型，这里是 json
                success: function(data) { // 请求成功时的回调函数
                    // 使用 jQuery 的 html 方法，更新显示角色信息的容器的内容
                    $("#role-info").html(`
                        <div class="character-card" onclick="selectCharacter('${data.role_name}')">
                            <div class="character-info">
                                <div class="character-name">角色名称: ${data.role_name}</div>
                                <div class="character-level-gold">角色等级: ${data.level}</div>
                                <div class="character-level-gold">角色经验值: ${data.experience}</div>
                                <div class="character-level-gold">角色生命值: ${data.health_points}</div>
                            </div>
                            <div class="character-map">角色法力值: ${data.mana_points}</div>
                            <div class="character-level-exp">角色金币: ${data.gold}</div>
                        </div>
                    `);
                },
                error: function(xhr, status, error) { // 请求失败时的回调函数
                    // 使用 jQuery 的 html 方法，显示错误信息
                    $("#role-info").html(`<p>获取角色信息失败，请稍后重试。</p>`);
                }
            });
        }

        // 使用 jQuery 的 ready 方法，当文档加载完成时，执行以下操作
        $(document).ready(function() {
            // 调用 getRoleInfo 函数，获取初始的角色信息
            getRoleInfo();
            // 使用 jQuery 的 change 方法，当用户选择角色时，调用 getRoleInfo 函数，更新角色信息
            $("#selected_role").change(function() {
                getRoleInfo();
            });
        });

        // 使用 jQuery 的 click 方法，当用户点击选择角色的按钮时，调用 selectCharacter 函数，跳转到选择角色的页面
        $("#select_role").click(function() {
            // 获取用户选择的角色名
            var role_name = $("#selected_role").val();
            // 调用 selectCharacter 函数，跳转到选择角色的页面
            selectCharacter(role_name);
        });

        function selectCharacter(characterName) {
            window.location.href = 'main.php?character=' + characterName;
        }

        function redirectToRegistration() {
            window.location.href = '../html/ROLE.html';
        }
        
    
    </script>

    
</body>

</html>