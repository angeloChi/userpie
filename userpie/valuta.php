<?php

require_once("models/config.php");

 if (!isUserLoggedInEsp()) {
      header('Location: login.php');
  }

    //Identificativo dello studio da valutare
    $id_studio = $_POST['valuta'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Valutazione Studio<?php echo $websiteName; ?> </title>
    <?php require_once("head_inc.php"); ?>
</head>
<body>
    <?php require_once("navbar.php"); ?>
    <h1> Implementazione a carico dei gruppi 2,3,4.</h1>


</body>
</html>

