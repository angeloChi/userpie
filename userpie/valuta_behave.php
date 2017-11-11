<?php

require_once("models/config.php");

 if (!isUserLoggedInEsp()) {
      header('Location: login.php');
  }

    //Identificativo dello studio da valutare
    $id_studio = $_POST['idstudio'];

	?>
<!DOCTYPE html>
<html>
<head>
    <title>Valutazione Studio<?php echo $websiteName; ?> </title>
    <?php require_once("head_inc.php"); ?>
</head>
<body>
    <?php 
		
		echo '<a href="../../smt2/admin/ext/admin-logs/index.php">Link smt2</a>';

?>
	

  <!--<h1> Implementazione a carico dei gruppi 3.(behaviour)</h1>-->



</body>
</html>