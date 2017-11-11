
<?php require_once("models/config.php");

   if(!empty($_POST)) {
          $id_studio = $_POST['idstudio'];
          $num_registered = $_POST["count_registered"];
          $titolo = $loggedInUser -> getTitoloStudio( $id_studio );
          //INVITA PARTECIPANTI REGISTRATI
          for($i=1; $i <= $num_registered; $i++){
            if($_POST["row".$i."-bit"] == "1"){
              $email_address = $_POST["row".$i];
              assegna_studio($email_address, $id_studio);
              send_Email_Registered_Study_Invitation($email_address, $titolo);

            }
          }
          //INVITA PARTECIPANTI NON REGISTRATI
          $mails = explode("\n", $_POST['invited']); 
          invita_part_non_registrati($mails, $titolo, $id_studio);

            //permette alla pagina esperto_home di avere conferma sull'invito dei partecipanti agli studi
            $_SESSION['partecipanti_invitati'] = '1';
       
    }
  
   header('Location: esperto_home.php');

?>