<?php
    include "../connection.php";
    global $connect;
    $method = $_SERVER['REQUEST_METHOD'];
    switch($method){
        case 'POST':
        if (
            isset($_POST['user_name']) 
            && isset($_POST['email']) 
            && isset($_POST['password'])  
        ){
            $user_name = mysqli_real_escape_string($connect, $_POST['user_name']);
            $email = mysqli_real_escape_string($connect, $_POST['email']);
            $password = mysqli_real_escape_string($connect, $_POST['password']);
        }
        $query = "INSERT INTO user_vgame (NAME, EMAIL, POINTS, PASSWORD, BUDGET) VALUES ('$user_name', '$email', 0, '$password', 100)";

        if ($connect->query($query)) {
            return true;
            echo 'connected';
		} else {
            echo 'fail';
            return false;
        }
        break;
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
	<title>VPTS_User Registeration</title>
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>
<body>
<div class="container">
        <form action = "index.php" method = "POST">
            <h2>User Registeration</h2>

            <div class="input-field">
                <label for="user_name">User Name:</label>
				<input placeholder="Enter User Name" id="user_name" name="user_name" type="text" class="validate" required>
            </div>

            <div class="input-field">
                <label for="email">Email</label>
				<input placeholder="Enter Email" id="email" name="email" type="text" class="validate" required>			
            </div>

            <div class="password">
                <label for="password">Password:</label>
				<input placeholder="Password" id="password" name="password" type="password" class="validate" required>
            </div>
            

            <button class="submit" type="submit">REGISTER</button>
        </form>
    </div>
</body>
</html>