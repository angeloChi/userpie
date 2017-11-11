<?php

  require_once("models/config.php");

  //Prevent the user visiting the logged in page if he/she is already logged in
  if(isUserLoggedInEsp()) { header("Location: esperto_home.php"); die(); }    //verifica se l'utente è un valutatore
  else if(isUserLoggedInPart()) { header("Location: partecipante_home.php"); die(); }   //verifica se l'utente è un partecipante
  if(isUserLoggedIn()) { header("Location: index.php"); die(); }      //verifica l'utente altrimenti effettua logout all'interno della funz
?>


<?php
  /*
    Below is a very simple example of how to process a new user.
     Some simple validation (ideally more is needed).

    The first goal is to check for empty / null data, to reduce workload here we let the user class perform it's own internal checks, just in case they are missed.
  */

//Forms posted
if(!empty($_POST))
{
    $errors = array();
    $email = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_pass = trim($_POST["passwordc"]);

    //Perform some validation
    //Feel free to edit / change as required

    if(minMaxRange(5,25,$username))
    {
      $errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
    }
    if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
    {
      $errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
    }
    else if($password != $confirm_pass)
    {
      $errors[] = lang("ACCOUNT_PASS_MISMATCH");
    }
    if(!isValidemail($email))
    {
      $errors[] = lang("ACCOUNT_INVALID_EMAIL");
    }

    //End data validation
    if(count($errors) == 0)
    {
        //Construct a user object
        $user = new UserPart($username,$password,$email,"2");

        //Checking this flag tells us whether there were any errors such as possible data duplication occured
        if(!$user->status)
        {
          if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
          if($user->email_taken)     $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
        }
        else
        {
          //Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
          if(!$user->userPieAddUser())
          {
            if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
            if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
          }
        }
    }
     if(count($errors) == 0)
     {
            if($emailActivation)
            {
                 $message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE2");
            } else {
                 $message = lang("ACCOUNT_REGISTRATION_COMPLETE_TYPE1");
            }
     }
     else
     {
           $message = '<span style="color: red;">'.implode(", ", $errors).'</span>';
     }
  }
?>

<!DOCTYPE html>
<html>
<head>

<title>Registrazione | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
</head>
<body>
    <?php require_once("navbar_default.php"); ?>

    <div class="modal-dialog">
  <div class="modal-header">
      <h1>Registrazione</h1>
</div>
  <div class="modal-body">


        <div id="success">

           <p><?php if (isset($message)) echo $message; ?></p>

        </div>

            <div id="regbox">
                <form class="form-horizontal" name="newUser" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <div class="form-group">
                <p>
                    <label>Username:</label>
                    <input type="text" class="form-control" name="username" />
                </p>

                <p>
                    <label>Password:</label>
                    <input type="password" class="form-control" name="password" />
                </p>

                <p>
                    <label>Reinserisci password:</label>
                    <input type="password" class="form-control" name="passwordc" />
                </p>

                <p>
                    <label>Email:</label>
                    <input type="text" class="form-control" name="email" />
                </p>
                </div>
        <div class="modal-footer">
<input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Registrazione" />
  </div>

                </form>

      </div>
      </div>




            </div>

      <div class="clear"></div>
   <p style="margin-top:30px; text-align:center;">
        <a href="<?php echo $websiteUrl; ?>">Home Page</a>
    </p>
</body>
</html>
