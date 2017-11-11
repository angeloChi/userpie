<?php

  require_once("models/config.php");

  //Prevent the user visiting the lost password page if he/she is already logged in
  if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<?php
  /*
    Below is a very simple example of how to process a lost password request
    We'll deal with a request in two stages, confirmation or deny then proccess

    This file handles 3 tasks.

    1. Construct new request.
    2. Confirm request. - Generate new password, update the db then email the user
    3. Deny request. - Close the request
  */

$errors = array();
$success_message = "";

//User has confirmed they want their password changed
//----------------------------------------------------------------------------------------------
if(!empty($_GET["confirm"]))
{
  $token = trim($_GET["confirm"]);

  if($token == "" || !validateactivationtoken($token,TRUE))
  {
    $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
  }
  else
  {
    $rand_pass = getUniqueCode(15);
    $secure_pass = generateHash($rand_pass);

    $userdetails = fetchUserDetails(NULL,$token);

    $mail = new userPieMail();

    //Setup our custom hooks
    $hooks = array(
        "searchStrs" => array("#GENERATED-PASS#","#USERNAME#"),
        "subjectStrs" => array($rand_pass,$userdetails["username"])
    );

    if(!$mail->newTemplateMsg("your-lost-password.txt",$hooks))
    {
      $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
    }
    else
    {
      if(!$mail->sendMail($userdetails["email"],"Your new password"))
      {
          $errors[] = lang("MAIL_ERROR");
      }
      else
      {
          if(!updatepasswordFromToken($secure_pass,$token))
          {
            $errors[] = lang("SQL_ERROR");
          }
          else
          {
            //Might be wise if this had a time delay to prevent a flood of requests.
            flagLostpasswordRequest($userdetails["username_clean"],0);

            $success_message  = lang("FORGOTPASS_NEW_PASS_EMAIL");
          }
      }
    }

  }
}

//----------------------------------------------------------------------------------------------

//User has denied this request
//----------------------------------------------------------------------------------------------
if(!empty($_GET["deny"]))
{
  $token = trim($_GET["deny"]);

  if($token == "" || !validateactivationtoken($token,TRUE))
  {
    $errors[] = lang("FORGOTPASS_INVALID_TOKEN");
  }
  else
  {

    $userdetails = fetchUserDetails(NULL,$token);

    flagLostpasswordRequest($userdetails['username_clean'],0);

    $success_message = lang("FORGOTPASS_REQUEST_CANNED");
  }
}




//----------------------------------------------------------------------------------------------


//Forms posted
//----------------------------------------------------------------------------------------------
if(!empty($_POST))
{
    $email = $_POST["email"];
    $username = $_POST["username"];

    //Perform some validation
    //Feel free to edit / change as required

    if(trim($email) == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
    }
    //Check to ensure email is in the correct format / in the db
    else if(!isValidemail($email) || !emailExists($email))
    {
      $errors[] = lang("ACCOUNT_INVALID_EMAIL");
    }

    if(trim($username) == "")
    {
      $errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
    }
    else if(!usernameExists($username))
    {
      $errors[] = lang("ACCOUNT_INVALID_USERNAME");
    }


    if(count($errors) == 0)
    {

      //Check that the username / email are associated to the same account
      if(!emailusernameLinked($email,$username))
      {
        $errors[] =  lang("ACCOUNT_USER_OR_EMAIL_INVALID");
      }
      else
      {
        //Check if the user has any outstanding lost password requests
        $userdetails = fetchUserDetails($username);

        if($userdetails["LostpasswordRequest"] == 1)
        {
          $errors[] = lang("FORGOTPASS_REQUEST_EXISTS");
        }
        else
        {
          //email the user asking to confirm this change password request
          //We can use the template builder here

          //We use the activation token again for the url key it gets regenerated everytime it's used.

          $mail = new userPieMail();

          $confirm_url = lang("CONFIRM")."\n".$websiteUrl."forgot-password.php?confirm=".$userdetails["activationtoken"];
          $deny_url = ("DENY")."\n".$websiteUrl."forgot-password.php?deny=".$userdetails["activationtoken"];

          //Setup our custom hooks
          $hooks = array(
            "searchStrs" => array("#CONFIRM-URL#","#DENY-URL#","#USERNAME#"),
            "subjectStrs" => array($confirm_url,$deny_url,$userdetails["username"])
          );

          if(!$mail->newTemplateMsg("lost-password-request.txt",$hooks))
          {
            $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
          }
          else
          {
            if(!$mail->sendMail($userdetails["email"],"Lost password request"))
            {
              $errors[] = lang("MAIL_ERROR");
            }
            else
            {
              //Update the DB to show this account has an outstanding request
              flagLostpasswordRequest($username,1);

              $success_message = lang("FORGOTPASS_REQUEST_SUCCESS");
            }
          }
        }
      }
    }
}
//----------------------------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
<head>
<title>Password dimenticata | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
</head>
    
<body>
   <?php require_once("navbar_default.php"); ?> 
    <div class="br_spaces">
        <br><br>
    </div>
    <div class="modal-dialog">
<!--        <div class="modal-header">-->
            <h1>Reimposta password</h1>
<!--        </div>-->
    <div class="modal-body">

        <br>

    <?php
        if(!empty($_POST) || !empty($_GET))
        {
            if(count($errors) > 0)
            {
    ?>
          <div id="errors">
              <?php errorBlock($errors); ?>
            </div>
        <?
            }
      else
      {
    ?>
            <div id="success">

                <p><?php echo $success_message; ?></p>

            </div>
        <?
      }
        }
        ?>

        <div id="regbox">
            <div class="form-group">
            <form name="newLostPass" class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

            <p>
                <label>Username:</label>
                <input type="text" class="form-control" name="username" />
            </p>


            <p>
                <label>Email:</label>
                <input type="text" class="form-control" name="email" />
            </p>
            </div>
        </div>
    </div>

<div class="modal-footer">
<input type="submit" class="btn btn-primary" name="new" id="newfeedform" value="Reset Password" />
</div>

        </form>
</div>

      <div class="clear"></div>
            <p style="margin-top:30px; text-align:center;"><a href="<?php echo $websiteUrl; ?>">Home Page</a>
            </p>
            <div class="clear">
            </div>
</body>
</html>


