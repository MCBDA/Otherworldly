<?php
// 引入常量定义
require_once 'common_use.php';

//启动会话
session_start();
$a = new DB_Connector();
$conn = $a->get_conn();
// 获取当前登录用户的角色信息
$user_id = $_SESSION['user_id']; // 假设用户ID存储在SESSION中

$sql = "select user_roles.*,map.* from user_roles join map on user_roles.map_id = map.map_id where user_roles.user_id = $user_id ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $role_name = $row["role_name"];
    $level = $row["level"];
    $experience = $row["experience"];
    $health_points = $row["health_points"];
    $mana_points = $row["mana_points"];
    $gold = $row["gold"];
    $mapname = $row["map_name"];
    $map_description = $row["description"];
    //地图上的怪物信息，格式为JSON,例如：{"monster_id": 1, "name": "怪物1"}
    $map_monsters = $row["monsters"];
    //地图上NPC信息，格式为JSON,例如：{"npc_id": 1, "name": "NPC1", "dialogue": "欢迎来到地点1！"}
    $map_npcs = $row["npcs"];
    
    //解析$map_monsters和$map_npcs为数组
    $map_monsters_array = json_decode($map_monsters, true);
    $map_npcs_array = json_decode($map_npcs, true);
} else {
    echo "找不到用户的角色信息";
}

$conn->close();
?>



<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8">
        <title>新手村</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
    <body>
        <h1 class="mytitle">勇者闯东南</h1>
        <div class="main">
            <div class="container">
            <button class="btn north">北边</button>
            <div class="middle">
                <button class="btn west">西边</button>
                <div class="map">
                    <h3><?php echo $map_description ?></h3>
                </div>
                <button class="btn east">东边</button>
            </div>
            <button class="btn south">南边</button>

            <!-- 地图信息 -->
            <div class="map-info">
                <h4>怪物</h4>
				<?php
                    echo '<div class="monster-container">';
                    // 使用循环来遍历所有的怪物
                    if (isset($map_monsters_array['monster_id'])) {
                        // 执行一维数组（单个怪物）时的操作
                        echo '<a href="#" onclick="fightMonster(\'' . $map_monsters_array['monster_id'] . '\')" class="monster-link">' . $map_monsters_array['name'] . '</a>';
                    } else {
                        // 执行二维数组时的操作
                        foreach ($map_monsters_array as $monster) {
                            echo '<a href="#" onclick="fightMonster(\'' . $monster['monster_id'] . '\')" class="monster-link">' . $monster['name'] . '</a>';
                        }
                    }
                    echo '</div>';
                ?>
				
				<!-- 这里是NPC -->
				<h4>NPC</h4>
				<?php
				    echo '<div class="monster-container">';
				    // 使用循环来遍历所有的怪物
				    if (isset($map_npcs_array['npc_id'])) {
				        // 执行一维数组（单个怪物）时的操作
				        echo '<a href="#" onclick="fightMonster(\'' . $map_npcs_array['npc_id'] . '\')" class="npc-link">' . $map_npcs_array['name'] . '</a>';
				    } else {
				        // 执行二维数组时的操作
				        foreach ($map_npcs_array as $npc) {
				            echo '<a href="#" onclick="fightMonster(\'' . $npc['npc_id'] . '\')" class="npc-link">' . $npc['name'] . '</a>';
				        }
				    }
				    echo '</div>';
				?>
            </div>
        </div>

        <!-- 用户角色信息 -->
        <div class="character-info">
            <h4><?php echo $role_name ?></h4>
            <p>等级: <span id="level"><?php echo $level ?></span></p>
            <p>金币: <span id="gold"><?php echo $gold ?></span></p>
            <p>血条:
            <div class="progress">
                <!-- <div class="progress-bar health" style="width:<?php echo($character_health / $character_max_health) * 100; ?>%"></div> -->
                <div class="progress-bar health" style="width:80%"></div>
            </div>
            </p>
            <p>蓝条:
            <div class="progress">
                <!-- <div class="progress-bar mana" style="width:<?php echo($character_mana / $character_max_mana) * 100; ?>%"></div> -->
                <div class="progress-bar mana" style="width:100%"></div>
            </div>
            </p>
            <p>经验值:
            <div class="progress">
                <!-- <div class="progress-bar exp" style="width:<?php echo($character_exp / $character_max_exp) * 100; ?>%"></div> -->
                <div class="progress-bar exp" style="width:60%"></div>
            </div>
            </p>

            <!-- 操作菜单 -->
            <div class="menu">
                <h4>操作菜单</h4>
                <button id="inventory-button" class="menu-button">背包</button>
                <button id="skills-button" class="menu-button">技能</button>
                <br />
                <button id="quests-button" class="menu-button">任务</button>
                <button id="shop-button" class="menu-button">商店</button>
            </div>
        </div>

        </div>
        

    </body>
</html>
