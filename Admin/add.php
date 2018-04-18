<?php
include '../connection.php';
global $connect;


if (isset($_POST['t_s'])) {
    # code...
    $team_name = $_POST['team_name'];
    $ti_query = "INSERT INTO teams(name) VALUES('$team_name');";
    if ($connect->query($ti_query)) {
        # code...
        ?><script>alert('Team Added!')</script><?php
    }else{
        ?><script>alert('Could not add team!')</script><?php
    }
}elseif (isset($_POST['t_p'])) {
    # code...
    $player_name = $_POST['player_name'];
    $team_id = $_POST['team_id'];
    $value = $_POST['value'];
    $pi_query = "INSERT INTO players(NAME, VALUE, TEAM_ID, POINTS) VALUES('$player_name', '$value', '$team_id', '0');";
    if ($connect->query($pi_query)) {
        # code...
        ?><script>alert('Player Added!')</script><?php
    }else{
        ?><script>alert('Could not add player!')</script><?php
    }
}
$team_query = "SELECT * FROM teams;";
$team_res = $connect->query($team_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <title>Add</title>
    <style>
        team_sub{
            color: white;
        }
    </style>
</head>
<body>
<nav class='blue'>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo" style='margin-left: 10px'>VPTG</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="index.php">Home</a></li>
        <li><a href="add.php">Add Team/Player</a></li>
      </ul>
    </div>
</nav>
<center>
<div class='container card'>
<div class="row">
    <form class="col s12" action='add.php' method='post'>
      <h4>Add Team</h4>
      <div class="row">
        <div class="input-field col s12">
          <input id="team_name" type="text" name='team_name' class="validate">
          <label for="team_name">Enter team name</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="team_sub" name='t_s' type="submit" class="btn blue" value="Add Team">
        </div>
      </div>
    </form>
  </div>
</div>
<div class='container card'>
<div class="row">
    <form class="col s12" action='add.php' method='post'>
      <h4>Add Player</h4>
      <div class="row">
        <div class="input-field col s12 m4 l4">
          <input id="player_name" type="text" name='player_name' class="validate">
          <label for="player_name">Enter player name</label>
        </div>
        <div class="input-field col s12 m4 l4">
          <input id="value" type="text" name='value' class="validate">
          <label for="value">Enter player value</label>
        </div>
        <div class="input-field col s12 m4 l4">
        
            <select name='team_id'>
                <option value="" disabled selected>Choose Team</option>
                <?php while($team_row = $team_res->fetch_array()){?>
                    <option value="<?php echo $team_row['ID'];?>"><?php echo $team_row['NAME'];?></option>
                <?php }?>
            </select>
            <label>Choose Team</label>
    
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="team_sub" name='t_p' type="submit" class="btn blue" value="Add Team">
        </div>
      </div>
    </form>
  </div>
</div>
</center>
<script>
 $(document).ready(function(){
    $('select').formSelect();
  });
</script>
</body>
</html>