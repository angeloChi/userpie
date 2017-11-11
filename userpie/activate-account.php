<?php

  require_once("models/config.php");

  //Prevent the user visiting the logged in page if he/she is already logged in
  if(isUserLoggedIn()) { header("Location: index.php"); die(); }
?>
<?php
  /*
    Activate a users account
  */
$errors = array();

//Get token param
if(isset($_GET["token"]))
{

    $token = $_GET["token"];

    if(!isset($token))
    {
      $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
    }
    else if(!validateactivationtoken($token)) //Check for a valid token. Must exist and active must be = 0
    {
      $errors[] = "Token non esiste o l'account e' gia' attivato";
    }
    else
    {
      //Activate the users account
      if(!setUseractive($token))
      {
        $errors[] = lang("SQL_ERROR");
      }
    }
}
else
{
  $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
}
?>




<!DOCTYPE html>
<html>
<head>
<title>Account Activation | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
</head>
<body>
<?php require_once("navbar_default.php"); ?>

  <div class="modal-ish">
  <div class="modal-header">
<h2>Attivazione</h2>
  </div>
  <div class="modal-body">

  <?php
        if(count($errors) > 0)
        {
      errorBlock($errors);
                } else { ?>
       <p>Attivazione completata. Puoi effettuare l'accesso <a href="login.php"> cliccando su questo link.</a></p>

            <?php }?>



 </div>


</div>



            <div class="clear"></div>

</body>
</html>







