<?php


class UserPart
{
  public $user_active = 0;
  private $clean_email;
  public $status = false;
  private $clean_password;
  private $clean_username;
  private $clean_group;
  private $unclean_username;
  public $sql_failure = false;
  public $mail_failure = false;
  public $email_taken = false;
  public $username_taken = false;
  public $activation_token = 0;

  function __construct($user,$pass,$email,$gruppo)  //modificato costruttore con aggiunta gruppo
  {
    //Used for display only
    $this->unclean_username = $user;

    //Sanitize
    $this->clean_email = sanitize($email);
    $this->clean_password = trim($pass);
    $this->clean_username = sanitize($user);
    $this->clean_gruppo = sanitize($gruppo);    //aggiunta variabile costruttore

    if(usernameExists($this->clean_username))
    {
      $this->username_taken = true;
    }
    //else if(emailExists($this->clean_email))
    //{
    //  $this->email_taken = true;
    //}
    else
    {
      //No problems have been found.
      $this->status = true;
    }


  }

  public function userPieAddUser()
  {
    global $db,$emailActivation,$websiteUrl,$db_table_prefix;

    //Prevent this function being called if there were construction errors
    if($this->status)
    {
      //aggiunta controllo username per proseguimento registrazione e attivazione account
    $sql = "SELECT user_id,
        password
        FROM ".$db_table_prefix."users
        WHERE
        email = '".$db->sql_escape($this->clean_email)."'
        AND
        active = 0
        LIMIT 1";
      if(returns_result($sql) > 0)   //verifica che la mail esista nel database prima per permettere di aggiornare i dati e registrare l'utente
      {

      //Construct a secure hash for the plain text password
      $secure_pass = generateHash($this->clean_password);

      //Construct a unique activation token
      $this->activation_token = generateactivationtoken();

      //Do we need to send out an activation email?
      if($emailActivation)
      {
        //User must activate their account first
        $this->user_active = 0;

        $mail = new userPieMail();

        //Build the activation message
        $activation_message = lang("ACTIVATION_MESSAGE",array($websiteUrl,$this->activation_token));

        //Define more if you want to build larger structures
        $hooks = array(
          "searchStrs" => array("#ACTIVATION-MESSAGE","#ACTIVATION-KEY","#USERNAME#"),
          "subjectStrs" => array($activation_message,$this->activation_token,$this->unclean_username)
        );

        /* Build the template - Optional, you can just use the sendMail function
        Instead to pass a message. */
        if(!$mail->newTemplateMsg("new-registration.txt",$hooks))
        {
          $this->mail_failure = true;
        }
        else
        {
          //Send the mail. Specify users email here and subject.
          //SendMail can have a third parementer for message if you do not wish to build a template.

          if(!$mail->sendMail($this->clean_email,"New User"))
          {
            $this->mail_failure = true;
          }
        }
      }
      else
      {
        //Instant account activation
        $this->user_active = 1;
      }


      if(!$this->mail_failure)
      {
          //Insert the user into the database providing no errors have been found.
          //aggiorna le credenziali dell'utente nel momento in cui si registra in register_partecipante.php
          $sql = "UPDATE ".$db_table_prefix. " `users`
          SET   `username` = '".$db->sql_escape($this->unclean_username)."',
              `username_clean` = '".$db->sql_escape($this->clean_username)."',
              `password` = '".$secure_pass."',
              `activationtoken` = '".$this->activation_token."',
              `LostpasswordRequest` = '0',
              `active` = '".$this->user_active."',
              `group_id` = '".$db->sql_escape($this->clean_gruppo)."',
              `sign_up_date` = '".time()."',
              `last_sign_in` = '0'
              WHERE `email` = '".$db->sql_escape($this->clean_email)."'";
            header('refresh: 10;');
        return $db->sql_query($sql);
      }
      }
    }
      
    
  }
}

?>
