<?php
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://localhost/vptg/Users/index.php?type=all',
    CURLOPT_USERAGENT => 'Admin Request'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
$resp = json_decode($resp, false);
$resp = $resp->response;
// Close request to clear up some resources
curl_close($curl);
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
        <li><a href="index.php">Home</a></li>
        <li><a href="add.php">Add Team/Player</a></li>
      </ul>
    </div>
</nav>
<div class='container'>
<ul class='collapsible popout'>
    <?php for($i = 0;$i<count($resp);$i++){?>
        <li>
            <div class="collapsible-header"><strong><?php echo $resp[$i]->name;?></strong></div>
            <div class="collapsible-body">Rank: <strong><?php echo $i+1;?></strong></br>Points: <strong><?php echo $resp[$i]->points;?></strong></div>
        </li>
    <?php }?>
</ul>
</div>
<script>
$(document).ready(function(){
    $('.collapsible').collapsible();
});
</script>
</body>
</html>