<?php 
    require_once( "models/config.php");
    if (!isUserLoggedInPart()) { 
        header( 'Location: login.php');
    } 
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <?php require_once( 'head_inc.php') ?>
</head>
<body>
    <h3> Implementazione dei questionari a carico dei gruppi 2</h3>
</body>
</html>