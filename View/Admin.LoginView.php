<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="../Asset/AdminLoginstyle.css">
</head>
<body>
    <div class="login-container">
        <h1>Welcome to Roy!</h1>
        <form method="post" onsubmit="return Login(event)">
            <label>Email:</label>
            <input type="email" placeholder="Enter your email" name="email" id="email">
            <label>Password:</label>
            <input type="password" placeholder="Enter your password" id="password">
            <input type="submit" value="Login">
        </form>
    </div>
    <script src="../Asset/AdminAjax.js"></script>
</body>
</html>