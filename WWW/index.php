<!DOCTYPE html>
<html>
<head>
    <title>用户登录</title>
</head>
<body>
    <h2>用户登录</h2>
    <form method="post" action="login_process.php">
        <label for="username">用户名:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">密码:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="登录">
		<br />
		<br />
		<a href="register.php">还没有账号,点击我注册</a>
    </form>
</body>
</html>
