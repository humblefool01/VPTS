<?php
    include '../connection.php';
    global $connect;
    $query = "SELECT players.id as id, players.name as name, value, points, teams.id as team_id, teams.name as team_name FROM players LEFT JOIN teams ON teams.id = players.team_id;";
    $res = $connect->query($query);
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
    <title>Admin</title>
</head>
<body>
<nav class='blue'>
    <div class="nav-wrapper">
      <a href="#" class="brand-logo" style='margin-left: 10px'>VPTG</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
        <li><a href="add.php">Add Player/Team</a></li>
        <li><a href="standings.php">Standings</a></li>
      </ul>
    </div>
</nav>
<div class='container'>
<ul class='collapsible popout'>
    <?php while($row = $res->fetch_array()){?>
        <li>
            <div class="collapsible-header"><strong><?php echo $row['name'];?></strong></div>
            <div class="collapsible-body">Team: <strong><?php echo $row['team_name'];?></strong></br>Value: <strong><?php echo $row['value'];?></strong></br>Points: <strong class='point<?php echo $row['id'];?>'><?php echo $row['points'];?></strong>
                <div class='row'>
                    <div class='col s12 m8 l8'>
                        <div class="input-field">
                            <input id="points_text<?php echo $row['id'];?>" type="number" class="validate">
                            <label for="first_name">Enter points</label>
                        </div>
                    </div>
                    <div class='col s12 m4 l4'>
                        <a class="waves-effect waves-light btn" id='update<?php echo $row['id'];?>' onclick='update(<?php echo $row['id'];?>)'>Update</a>
                    </div>
                </div>
            </div>
        </li>
    <?php }?>
</ul>
</div>
<script>
$(document).ready(function(){
    $('.collapsible').collapsible();
});

function update(id) {
    var points = $('#points_text'+id).val();
    $.ajax({
        url:'admin.api.php',
        type: 'POST',
        data: {id: id, points: points},
        success: function(res){
            if(res == 'success'){
                M.toast({html: 'Points updated successfully!'});
                $('.point'+id).text(parseInt($('.point'+id).text())+parseInt(points));
                $('#points_text'+id).val('');
            }else{
                M.toast({html: 'Could not update points!'});   
            }
        }
    });
}
</script>
</body>
</html>