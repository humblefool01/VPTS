<?php
    include '../connection.php';
    global $connect;
    $id = $_POST['id'];
    $points = $_POST['points'];
    $p_query = "SELECT user_id, points FROM buy LEFT JOIN user_vgame ON buy.user_id = user_vgame.id WHERE player_id = '$id';";
    $res = $connect->query($p_query);
    while($row = $res->fetch_array()){
        $new_points = $points + $row['points'];
        $u_id = $row['user_id'];
        $update_p = "UPDATE user_vgame SET points = '$new_points' WHERE id='$u_id';";
        $connect->query($update_p);
    }
    $p2_query = "UPDATE players SET points = points+'$points' WHERE id='$id';";
    if($connect->query($p2_query))
        echo 'success';
    else 
        echo 'fail';
?>