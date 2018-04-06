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
            $query = "INSERT INTO user_vgame (NAME, EMAIL, POINTS, PASSWORD, BUDGET) VALUES ('$user_name', '$email', 0, '$password', 15000)";

            if ($connect->query($query)) {
            echo 'true';
                return true;
            } else {
                echo 'fail';
                return false;
            }
            break;
        }
        case 'GET':
        if(isset($_GET['type']) && $_GET['type']=='all'){
            $response = array();
            $query = "SELECT * FROM user_vgame order by points";
            $res = $connect->query($query);
            while($row=$res->fetch_array()){
                array_push($response, array('id'=>$row['ID'],'name'=>$row['NAME'],'points'=>$row['POINTS']));
            }
            echo json_encode(array('response'=>$response));
        }
    }
?>