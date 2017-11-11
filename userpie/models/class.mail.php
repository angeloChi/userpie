<?php

require "phpmailer/class.phpmailer.php";
require "phpmailer/class.smtp.php";

class userPieMail {

  //UserPie uses a text based system with hooks to replace various strs in txt email templates
  public $contents = NULL;

  //Function used for replacing hooks in our templates
  public function newTemplateMsg($template,$additionalHooks)
  {
    global $mail_templates_dir,$debug_mode;

    $this->contents = file_get_contents($mail_templates_dir.$template);

    //Check to see we can access the file / it has some contents
    if(!$this->contents || empty($this->contents))
    {
      if($debug_mode)
      {
        if(!$this->contents)
        {
          echo lang("MAIL_TEMPLATE_DIRECTORY_ERROR",array(getenv("DOCUMENT_ROOT")));

          die();
        }
        else if(empty($this->contents))
        {
          echo lang("MAIL_TEMPLATE_FILE_EMPTY");

          die();
        }
      }

      return false;
    }
    else
    {
      //Replace default hooks
      $this->contents = replaceDefaultHook($this->contents);

      //Replace defined / custom hooks
      $this->contents = str_replace($additionalHooks["searchStrs"],$additionalHooks["subjectStrs"],$this->contents);

      //Do we need to include an email footer?
      //Try and find the #INC-FOOTER hook
      if(strpos($this->contents,"#INC-FOOTER#") !== FALSE)
      {
        $footer = file_get_contents($mail_templates_dir."email-footer.txt");
        if($footer && !empty($footer)) $this->contents .= replaceDefaultHook($footer);
        $this->contents = str_replace("#INC-FOOTER#","",$this->contents);
      }

      return true;
    }
  }

  public function sendMail($email,$subject,$msg = NULL)
  {
     global $websiteName,$emailAddress;

    $mail = new PHPmailer();
    $mail->From = $emailAddress;
    $mail->FromName = "UTAssistant";
    $mail->addAddress($email,$email);
    $mail->Subject = $subject;

    if($msg == NULL)
    $msg = $this->contents;

    $message = '';
    $message .= $msg;
    $message = wordwrap($message, 70);

    $mail->Body    = $msg;
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->isSMTP(true);
    $mail->Host =       'smtp.gmail.com';
    $mail->Port =       '465';
    $mail->SMTPAuth =   'true';
    $mail->SMTPSecure = 'ssl';
    $mail->Username =   'utassistantbrindisi@gmail.com';
    $mail->Password =   'UT123456';
    // Try to send the mail.  Will throw an exception on failure.
    return  $mail->send();

  }
}


?>
