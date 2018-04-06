<?php
    include "../connection.php";
    global $connect;
    $method = $_SERVER['REQUEST_METHOD'];
    switch($method){
        case 'POST':
        if (
            isset($_POST['player_name']) 
            && isset($_POST['team_id']) 
            && isset($_POST['value']) 
            && isset($_POST['points']) 
        ){
            $player_name = mysqli_real_escape_string($connect, $_POST['player_name']);
            $team_id = mysqli_real_escape_string($connect, $_POST['team_id']);
            $value = mysqli_real_escape_string($connect, $_POST['value']);
            $points = mysqli_real_escape_string($connect, $_POST['points']);
            $query = "INSERT INTO players (NAME, TEAM_ID, VALUE, POINTS) VALUES ('$player_name', '$team_id', '$value', '$points')";
		    if ($connect->query($query)) {
                echo 'true';
                return true;
            } else {
                echo 'fail';
                return false;
            }
            break;
        }

        else if(isset($_POST['user_id']) && isset($_POST['player_id'])){
            $user_id = $_POST['user_id'];
            $player_id = $_POST['player_id'];
            try{
                $connect->beginTransaction();
                $buy_query = "INSERT INTO buy(player_id, user_id) VALUES ('$player_id', '$user_id');";
                if($connect->query($buy_query)){
                    $connect->commit();
                }
            }catch (Exception $e){
                $connect->rollback();
                echo 'false';
            }
            break;
        }

        case 'GET':
        if (isset($_GET['type']) && $_GET['type'] == 'pool' && isset($_GET['user_id'])) {
            # code...
            $response = array();
            $user_id = $_GET['user_id'];
            $query = "SELECT players.id as id, players.name, value, points, teams.id as team_id, teams.name as team_name FROM players LEFT JOIN teams ON players.team_id = teams.id;";
            $res = $connect->query($query);
            while($row = $res->fetch_array()){
                $player_id = $row['id'];
                $query1 = "SELECT id FROM buy WHERE player_id = '$player_id' AND user_id = '$user_id';";
                $res1 = $connect->query($query1);
                if($res1->num_rows == 0){
                    $buy_id = 0;
                }else{
                    $buy_id = 1;
                }
                array_push($response, array('buy_id'=>$buy_id, 'player_id'=>$player_id, 'user_id'=>$user_id, 'name'=>$row['name'], 'team_name'=>$row['team_name'], 'value'=>$row['value'], 'points'=>$row['points']));
            }
            echo json_encode(array('response'=>$response));
        }else
        if(isset($_GET['username'])){
            $response = array();
            $username = $_GET['username'];
            $query = "SELECT user_vgame.id as id, name, points, budget, points FROM user_vgame WHERE name='$username' ";
            $res = $connect->query($query);
            $row = $res->fetch_array();
            array_push($response, array('id'=>$row['id'], 'name'=>$row['name'], 'points'=>$row['points'], 'budget'=>$row['budget']));
            echo json_encode(array('response'=>$response));
            exit(0);
        }elseif (isset($_GET['user_id']) && isset($_GET['player_id'])) {
            # code...
            $response = array();
            $user_id = $_GET['user_id'];
            $player_id = $_GET['player_id'];
            $query2 = "SELECT * FROM players WHERE id='$player_id';";
            $res2 = $connect->query($query2);
            $row2 = $res2->fetch_array();
            $value = $row2['VALUE'];
            $query3 = "SELECT * FROM user_vgame WHERE id='$user_id';";
            $res3 = $connect->query($query3);
            $row3 = $res3->fetch_array();
            $budget = $row3['BUDGET'];
            $new_budget = $budget-$value;
            if($new_budget >= 0 ){
                $query4 = "INSERT INTO buy(user_id, player_id) VALUES('$user_id','$player_id');";
                if($connect->query($query4)){
                    $query5 = "UPDATE user_vgame SET budget='$new_budget' WHERE id='$user_id';";
                    if($connect->query($query5)){
                        array_push($response, array('status'=>'success', 'budget'=>$new_budget));
                    }
                }else{
                    array_push($response, array('status'=>'failed'));
                }
            }else {
                array_push($response, array('status'=>'balance_error'));
            }
            echo json_encode(array('response'=>$response));
        }
        else if(isset($_GET['user_id'])){
            $response = array();
            $user_id = $_GET['user_id'];
            $query = "SELECT buy.id as id, user_id, player_id, players.name, team_id, teams.name as team_name, players.points as points, value FROM buy LEFT JOIN players ON players.id = buy.player_id LEFT JOIN teams ON teams.id = players.team_id WHERE user_id='$user_id';";
            $res = $connect->query($query);
            while ($row = $res->fetch_array()) {
                array_push($response, array('buy_id'=>$row['id'], 'player_id'=>$row['player_id'], 'user_id'=>$row['user_id'], 'name'=>$row['name'], 'team_name'=>$row['team_name'], 'points'=>$row['points'], 'value'=>$row['value']));
            }
            echo json_encode(array('players' => $response));
            exit(0);
        }elseif (isset($_GET['buy_id'])) {
            # code...
            $response = array();
            $buy_id = $_GET['buy_id'];
            $query1 = "SELECT * FROM buy WHERE id = '$buy_id';";
            $res1 = $connect->query($query1);
            $row1 = $res1->fetch_array();
            $player_id = $row1['player_id'];
            $user_id = $row1['user_id'];
            $query2 = "SELECT * FROM players WHERE ID='$player_id';";
            $res2 = $connect->query($query2);
            $row2 = $res2->fetch_array();
            $value = $row2['VALUE'];
            $query3 = "SELECT * FROM user_vgame WHERE ID='$user_id';";
            $res3 = $connect->query($query3);
            $row3 = $res3->fetch_array();
            $budget = $row3['BUDGET'];
            $new_budget = $budget + $value;
            $query4 = "DELETE FROM buy WHERE id='$buy_id';";
            if($connect->query($query4)){
                $query5 = "UPDATE user_vgame SET budget='$new_budget' WHERE id='$user_id';";
                if($connect->query($query5)){
                    array_push($response, array('status'=>'success', 'budget'=>$new_budget));
                }
            }else{
                array_push($response, array('status'=>'failed'));
            }
            echo json_encode(array('response'=>$response));
        }
    }

?>