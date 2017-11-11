<?php

  require_once("models/config.php");

  //Prevent the user visiting the lost password page if he/she is already logged in
  if(isUserLoggedIn()) { header("Location: account.php"); die(); }
?>
<?php
  /*
    Below process a new activation link for a user, as they first activation email may have never arrived.
  */

$errors = array();
$success_message = "";

//Forms posted
//----------------------------------------------------------------------------------------------
if(!empty($_POST) && $emailActivation)
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
      $errors[] =  lang("ACCOUNT_SPECIFY_USERNAME");
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
        $errors[] = lang("ACCOUNT_USER_OR_EMAIL_INVALID");
      }
      else
      {
        $userdetails = fetchUserDetails($username);

        //See if the user's account is activation
        if($userdetails["active"]==1)
        {
          $errors[] = lang("ACCOUNT_ALREADY_ACTIVE");
        }
        else
        {
          $hours_diff = round((time()-$userdetails["last_activation_request"]) / (3600*$resend_activation_threshold),0);

          if($resend_activation_threshold!=0 && $hours_diff <= $resend_activation_threshold)
          {
            $errors[] = lang("ACCOUNT_LINK_ALREADY_SENT",array($resend_activation_threshold));
          }
          else
          {
            //For security create a new activation url;
            $new_activation_token = generateactivationtoken();

            if(!updatelast_activation_request($new_activation_token,$username,$email))
            {
              $errors[] = lang("SQL_ERROR");
            }
            else
            {
              $mail = new userPieMail();

              $activation_url = $websiteUrl."activate-account.php?token=".$new_activation_token;

              //Setup our custom hooks
              $hooks = array(
                "searchStrs" => array("#ACTIVATION-URL","#USERNAME#"),
                "subjectStrs" => array($activation_url,$userdetails["username"])
              );

              if(!$mail->newTemplateMsg("resend-activation.txt",$hooks))
              {
                $errors[] = lang("MAIL_TEMPLATE_BUILD_ERROR");
              }
              else
              {
                if(!$mail->sendMail($userdetails["email"],"Activate your UserPie Account"))
                {
                  $errors[] = lang("MAIL_ERROR");
                }
                else
                {
                  //Success, user details have been updated in the db now mail this information out.
                  $success_message = lang("ACCOUNT_NEW_ACTIVATION_SENT");
                }
              }
            }
          }
        }
      }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Reinvia email di attivazione | <?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
</head>
<body>
    <?php require_once("navbar_default.php"); ?> 
    <div class="br_spaces">
        <br>
    </div>
    <div class="modal-dialog">
        <div class="modal-header">
        <h1>Reinvia email di attivazione</h1>
            </div>
        <div class="modal-body">
            
            <?php
            if(!empty($_POST) || !empty($_GET["confirm"]) || !empty($_GET["deny"]) && $emailActivation)
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
            
            
            <?php
            
            if(!$emailActivation)
            {
                echo lang("FEATURE_DISABLED");
            }
            else
            {
            ?>
            <div class="form-group">
                <form name="resendActivation"  class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    
                    
                    <p>
                        <label>Username:</label>
                        <input type="text" class="form-control" name="username" />
                    </p>
                    
                    <p>
                        <label>Email:</label>
                        <input type="text" class="form-control" name="email" />
                    </p>
                    </div>
                <div class="modal-footer">
                    <p><input type="submit" class="btn btn-primary btn-large" name="activate" id="newfeedform" value="Resend" /></p>
                    
                    
                    </form>
                
                <? } ?>
            </div>
        </div>
    </div>
    
    <div class="clear"></div>
    <p style="margin-top:30px; text-align:center;">
        <a href="<?php echo $websiteUrl; ?>">Home Page</a>
    </p>
    
    
    </body>
</html>


