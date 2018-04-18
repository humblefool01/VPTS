<?php
    include "../connection.php";
    global $connect;
    $method = $_SERVER['REQUEST_METHOD'];
    switch($method){
        case 'POST':
        if (
            isset($_POST['user_name']) 
            && isset($_POST['password'])  
        ){
            $user_name = mysqli_real_escape_string($connect, $_POST['user_name']);
            $password = mysqli_real_escape_string($connect, $_POST['password']);
        }
        $query = "SELECT * FROM user_vgame WHERE NAME = '$user_name' AND PASSWORD = '$password';";
	$res = $connect->query($query);
        if ($res->num_rows != 0) {
	    echo 'true';
            return true;
	} else {
            echo 'fail';
            return false;
        }
        break;
    }
?>