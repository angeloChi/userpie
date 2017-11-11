<?php

  require_once("models/config.php");

  //Prevent the user visiting the logged in page if he/she is already logged in
  if(isUserLoggedInEsp()) { header("Location: esperto_home.php"); die(); }    //verifica se l'utente è un valutatore
  else if(isUserLoggedInPart()) { header("Location: partecipante_home.php"); die(); }   //verifica se l'utente è un         partecipante
  else if(isUserLoggedIn()) { header("Location: index.php"); die(); }


//verifica l'utente altrimenti effettua logout all'interno della funz
?>

<?php
  /*
    Below is a very simple example of how to process a login request.
    Some simple validation (ideally more is needed).
  */

//Forms posted
if(!empty($_POST))
{

    $errors = array();
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

        if(!isset($_POST["remember_me"])){
    $remember_choice = 0;
        }else{
            $remember_choice = 1;
        }

    //Perform some validation
    //Feel free to edit / change as required
    if($username == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
    }
    if($password == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
    }

    //End data validation
    if(count($errors) == 0)
    {
      //A security note here, never tell the user which credential was incorrect
      if(!usernameExists($username))
      {
        $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
      }
      else
      {
        $userdetails = fetchUserDetails($username);

        //See if the user's account is activation
        if($userdetails["active"]==0)
        {
          $errors[] = lang("ACCOUNT_INACTIVE");
        }
        else
        {
          //Hash the password and use the salt from the database to compare the password.
          $entered_pass = generateHash($password,$userdetails["password"]);

          if($entered_pass != $userdetails["password"])
          {
            //Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
            $errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
          }
          else
          {
            //passwords match! we're good to go'

            //Construct a new logged in user object
            //Transfer some db data to the session object
            $loggedInUser = new loggedInUser();
            $loggedInUser->email = $userdetails["email"];
            $loggedInUser->user_id = $userdetails["user_id"];
            $loggedInUser->hash_pw = $userdetails["password"];
            $loggedInUser->display_username = $userdetails["username"];
            $loggedInUser->clean_username = $userdetails["username_clean"];
$loggedInUser->remember_me = $remember_choice;
$loggedInUser->remember_me_sessid = generateHash(uniqid(rand(), true));

            //Update last sign in
            $loggedInUser->updatelast_sign_in();

            if($loggedInUser->remember_me == 0)
                            $_SESSION["userPieUser"] = $loggedInUser;
                        else if($loggedInUser->remember_me == 1) {   //IMPOSTAZIONE DEFAULT 0 - per inserimento sessione
$db->sql_query("INSERT INTO ".$db_table_prefix."sessions VALUES('".time()."', '".serialize($loggedInUser)."', '".$loggedInUser->remember_me_sessid."')");
setcookie("userPieUser", $loggedInUser->remember_me_sessid, time()+parseLength($remember_me_length));
}

            //Redirect to user account page
            header("Location: index.php");
            die();
          }
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>

<title>Login | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>

</head>

<body>
<?php require_once("navbar_default.php"); ?>
    
    <div class="br_spaces">
        <br>
    </div>

<div class="modal-dialog">
  <div class="modal-header">
      <h2><strong>Accedi</strong></h2>
  </div>
  <div class="modal-body">



        <?php
        if(!empty($_POST))
        {
        ?>
        <?php
        if(count($errors) > 0)
        {
        ?>
        <div id="errors">
        <?php errorBlock($errors); ?>
        </div>
        <?php
        } }
        ?>

        <?php if(isset($_GET['status']) AND $_GET['status'] == "success")
        {

        echo "<p>Account creato correttamente. Addesso puoi accedere.</p>";

      }
    else
    {
        $_GET['stauts'] = "";
    }

      ?>


        <form class="form-horizontal" name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
          <div class="form-group">
              <label>Username:</label>
              <input type="text" class="form-control" name="username" placeholder="Inserisci username" />
          </div>

         <div class="form-group">
               <label >Password:</label>
               <input type="password" class="form-control" name="password" placeholder="Inserisci password" />
          </div>

       <div class="checkbox" align="center" >
         <input type="checkbox" name="remember_me" value="1">
            Ricordami
         </input>
          </div>




  </div>

         <div class="modal-footer">
             <input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Accedi" />
          </div>

         </form>

</div>




            <div class="clear"></div>
<p style="margin-top:30px; text-align:center;">
    <a href="<?php echo $websiteUrl; ?>">Home Page / </a>
    <a href="forgot-password.php">Password dimenticata?</a>
</p>


</body>
</html>


