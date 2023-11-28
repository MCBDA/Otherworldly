<?php
//启动会话
session_start();
require_once'./common_use.php';

// 连接到数据库
$db = new DB_Connector();
$conn = $db->get_conn();
// $conn = new mysqli(HOSTNAME, DATAUSERNAME, DATAPASSWORD, DATABASE);

// // 检查连接是否成功
// if ($conn->connect_error) {
//     die("连接数据库失败: " . $conn->connect_error);
// } else {
	
// }

// 获取当前登录用户的角色信息
$user_id = $_SESSION['user_id']; // 假设用户ID存储在SESSION中

$sql = "SELECT * FROM user_roles WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $role_name = $row["role_name"];
    $level = $row["level"];
    $experience = $row["experience"];
    $health_points = $row["health_points"];
    $mana_points = $row["mana_points"];
    $gold = $row["gold"];
} else {
    echo "找不到用户的角色信息";
}
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
        <div class="character-card" onclick="selectCharacter('角色名称','角色等级')">
            <div class="character-info">
                <div class="character-name">角色名称: <?php echo $role_name; ?></div>
                <div class="character-level-gold">角色等级: <?php echo $level; ?></div>
            
            
                <div class="character-level-gold">角色经验值: <?php echo $experience; ?></div>
                <div class="character-level-gold">角色生命值: <?php echo $health_points; ?></div>
            </div>

                <div class="character-map">角色法力值: <?php echo $mana_points; ?></div>
                <div class="character-level-exp">角色金币: <?php echo $gold; ?></div>
        </div>
        <div class="register-card" onclick="redirectToRegistration()">
            <h2>注册角色</h2>
            <p>创建全新的游戏角色</p>
        </div>

        <form action="选择后续处理脚本.php" method="post">
        <label for="selected_role">请选择一个角色：</label>
        <select name="selected_role" id="selected_role">
            <option value="<?php echo $role_name; ?>"><?php echo $role_name; ?></option>
            <!-- 这里可以添加其他可选角色的选项，从数据库中查询或手动添加 -->
        </select>
        <br>
        <input type="submit" value="选择角色">
    </form>
        
    </div>
    <script>

        function selectCharacter(characterName) {
            window.location.href = 'new_file.html?character=' + characterName;
        }

        function redirectToRegistration() {
            window.location.href = './new role.php';
        }
    
    </script>

    
</body>

</html>