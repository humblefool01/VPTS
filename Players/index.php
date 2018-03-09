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

        }
        $query = "INSERT INTO players (NAME, TEAM_ID, VALUE, POINTS) VALUES ('$player_name', '$team_id', '$value', '$points')";
		
		if ($connect->query($query)) {
            return true;
            echo 'connected';
		} else {
            echo 'fail';
            return false;
		}
    break;
    }


	// function registerPlayer($player_name, $team_id, $value, $points) {

	// 	$query = "INSERT INTO players "
	// 				."(NAME, TEAM_ID, VALUE, POINTS) "
	// 				."VALUES ('$player_name', '$team_id', '$value', '$points')";
		
	// 	if ($connect->query($query)) {
    //         return true;
    //         echo 'afasdvsaaaasbghd';
	// 	} else {
    //         echo '3';
    //         return false;
	// 	}
	// }

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
	<title>VPTS_Player Registeration</title>
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action = "index.php" method = "POST">
            <h2>Player Registeration</h2>

            <div class="input-field">
                <label for="player_name">Player Name:</label>
				<input placeholder="Enter Player Name" id="player_name" name="player_name" type="text" class="validate" required>
            </div>

            <div class="input-field">
                <label for="team_id">Team ID:</label>
				<input placeholder="Team ID" id="team_id" name="team_id" type="number" class="validate" required>
            </div>
            
            <div class="input-field">
                <label for="value">Value</label>
				<input placeholder="Enter Value" id="value" name="value" type="number" class="validate" required>			
            </div>

            <div class="input-field">
                <label for="points">Points</label>
				<input placeholder="Enter Points" id="points" name="points" type="number" class="validate" required>
            </div>

            <button class="submit" type="submit">REGISTER</button>
        </form>
    </div>
</body>
</html>