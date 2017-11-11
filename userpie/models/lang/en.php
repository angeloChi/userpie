<?php

  /*
    %m1% - Dymamic markers which are replaced at run time by the relevant index.
  */

  $lang = array();

  //Account
  $lang = array_merge($lang,array(
    "ACCOUNT_SPECIFY_USERNAME" => "Inserire username",
    "ACCOUNT_SPECIFY_PASSWORD" => "Inserire password",
    "ACCOUNT_SPECIFY_EMAIL" => "Inserire indirizzo email",
    "ACCOUNT_INVALID_EMAIL" => "Indirizzo email non valido",
    "ACCOUNT_INVALID_USERNAME" => "username non valido",
    "ACCOUNT_USER_OR_EMAIL_INVALID" => "username o indirizzo email non valido",
    "ACCOUNT_USER_OR_PASS_INVALID" => "username o password non valido",
    "ACCOUNT_ALREADY_ACTIVE" => "L'account e' gia' attivato",
    "ACCOUNT_INACTIVE" => "Il tuo account non e' attivo. Controlla la tua email  o  la cartella spam per avere informazioni",
    "ACCOUNT_USER_CHAR_LIMIT" => "Lo username non deve essere minore di %m1% caratteri o maggiore di %m2%",
    "ACCOUNT_PASS_CHAR_LIMIT" => "La password non deve essere minore di %m1% caratteri o maggiore di %m2%",
    "ACCOUNT_PASS_MISMATCH" => "le password devono essere uguali",
    "ACCOUNT_USERNAME_IN_USE" => "username %m1% gia' presente",
    "ACCOUNT_EMAIL_IN_USE" => "email %m1% gia' presente",
    "ACCOUNT_LINK_ALREADY_SENT" => "Email di attivazione gia' inviata a questo indirizzo email da %m1% ora/e",
    "ACCOUNT_NEW_ACTIVATION_SENT" => "Ti abbiamo inviato un link di attivazione, controlla la tua email",
    "ACCOUNT_NOW_ACTIVE" => "Il tuo account non e' attivo",
    "ACCOUNT_SPECIFY_NEW_PASSWORD" => "Inserire nuova password",
    "ACCOUNT_NEW_PASSWORD_LENGTH" => "La nuova password non deve essere inferiore di %m1% caratteri o maggiore di %m2%",
    "ACCOUNT_PASSWORD_INVALID" => "Password non valida",
    "ACCOUNT_EMAIL_TAKEN" => "Questo indirizzo email e' gia' presente",
    "ACCOUNT_DETAILS_UPDATED" => "Dettagli account aggiornati",
    "ACTIVATION_MESSAGE" => "E' necessario attivare l'account prima di fare il Login, cliccare il seguente link per attivare il tuo account \n\n %m1%activate-account.php?token=%m2% . Se il link non e' attivo copiarlo ed incollarlo
    nella barra degli indirizzi del browser.
    ",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE1"  => "Registrazione avvenuta con successo. Adesso puoi accedere a <a href=\"login.php\">here</a>.",
    "ACCOUNT_REGISTRATION_COMPLETE_TYPE2"  => "Registrazione avvenuta con successo. Presto riceverai una mail di attivazione. \n E' necessario attivare l'account prima di accedere.",
  ));

  //Forgot password
  $lang = array_merge($lang,array(
    "FORGOTPASS_INVALID_TOKEN"        => "Token non valido",
    "FORGOTPASS_NEW_PASS_EMAIL"        => "Ti abbiamo inviato una nuova password",
    "FORGOTPASS_REQUEST_CANNED"        => "Richiesta password dimenticata cancellata",
    "FORGOTPASS_REQUEST_EXISTS"        => "Richiesta password in sospeso per questo account",
    "FORGOTPASS_REQUEST_SUCCESS"      => "Ti abbiamo inviato una password per poterti riloggare",
  ));

  //Miscellaneous
  $lang = array_merge($lang,array(
    "CONFIRM"                => "Conferma",
    "DENY"                  => "Nega",
    "SUCCESS"                => "Successo",
    "ERROR"                  => "Errore",
    "NOTHING_TO_UPDATE"            => "Niente da aggiornare",
    "SQL_ERROR"                => "Fatal SQL error",
    "MAIL_ERROR"              => "Email errata, contatta l'amministratore del server",
    "MAIL_TEMPLATE_BUILD_ERROR"        => "Error building email template",
    "MAIL_TEMPLATE_DIRECTORY_ERROR"      => "Unable to open mail-templates directory. Perhaps try setting the mail directory to %m1%",
    "MAIL_TEMPLATE_FILE_EMPTY"        => "Template file is empty... nothing to send",
    "FEATURE_DISABLED"            => "This feature is currently disabled",
  ));
?>
