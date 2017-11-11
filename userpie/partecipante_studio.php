<?php

 require_once("models/config.php");

  /*
  * Uncomment the "else" clause below if e.g. userpie is not at the root of your site.
  */
  if (!isUserLoggedInPart()) {
      header('Location: login.php');
  }
   //prova fatta da me //
   $prova = $loggedInUser->user_id;
   function prova_idutente(){
   $GLOBALS['x'] = $GLOBALS['prova'];
   }
 prova_idutente();
 echo"Stampa variabile superglobale utente" .$x.".<br>";
   
   ///////////////////////
   
  
  
  if (isset($_POST['id_studio'])) {
	  
      
      $idstudio = $_POST['id_studio'];
      $_SESSION['idstudio'] = $idstudio;
      $currenttask = 1;
      $_SESSION['currenttask'] = $currenttask;

	 
	  
      $flags = $loggedInUser->getStudyFlags($idstudio);
      $_SESSION['flag_audio'] = $flags['flag_audio'];
      $_SESSION['flag_video'] = $flags['flag_video'];
      $_SESSION['flag_comportamento'] = $flags['flag_comportamento'];
      $_SESSION['flag_q_aa'] = $flags['flag_q_aa'];
      $_SESSION['flag_q_sus'] = $flags['flag_q_sus'];
      
      $numtasks = $loggedInUser -> getNumTask( $idstudio );
      $_SESSION['numtasks'] = $numtasks;
      
      $results = $loggedInUser -> getInfoTask( $idstudio, $currenttask);
      $_SESSION['idtask'] = $results['id_task'];
      $_SESSION['obiettivo']  = $results['obiettivo'];
      $_SESSION['istruzioni'] = $results['istruzioni'];
      $_SESSION['url'] = $results['url'];
      $idtask = $_SESSION['idtask'];
      $obiettivo = $_SESSION['obiettivo'];
      $istruzioni = $_SESSION['istruzioni'];
      $url = $_SESSION['url'];
      
      if($currenttask == $numtasks){
         if( $_SESSION['flag_q_aa'] == $_SESSION['flag_q_sus'] ) {
             $_SESSION['status'] = 'termina-noquest';
             $status = 'termina-noquest';
         } else {
             $_SESSION['status'] = 'questionario';
             $status = 'questionario';
         }
      } else {
          $_SESSION['status'] = 'task';
          $status = 'task';
      }

  } else {
      switch($_SESSION['status']){
          case 'task':          
          case 'questionario':
          case 'termina-noquest':
              $currenttask = $_SESSION['currenttask'];
              $idtask = $_SESSION['idtask'];
              $obiettivo = $_SESSION['obiettivo'];
              $istruzioni = $_SESSION['istruzioni'];
              $url = $_SESSION['url'];
              $numtasks =  $_SESSION['numtasks'];
              if($currenttask == $numtasks ){
                 if( $_SESSION['flag_q_aa'] == $_SESSION['flag_q_sus'] ) {
                     $_SESSION['status'] = 'termina-noquest';
                     $status = 'termina-noquest';
                 } else {
                     $_SESSION['status'] = 'questionario';
                     $status = 'questionario';
                 }
              }
              break;
          case 'termina':
              //nessun codice
              
              break;
      }
      
  }
  
  
?>
   <!DOCTYPE html>
<html>

<head>

    <title>Partecipante Home
        <?php echo $websiteName; ?>
    </title>
    <?php require_once("head_inc.php"); ?>
    <script src="assets/js/partecipa_studio.js"></script>



</head>
<?php if(($_SESSION['currenttask'] == 1) || (!isset($_SESSION["studioIniziato"])) || (isset($_SESSION["studioIniziato"]) &&($_SESSION["studioIniziato"] == 0))){
    echo "<body onload='inizioStudio()'>";
    $_SESSION["studioIniziato"] = 1;
}else{
    echo "<body onload='showModal()'>";
}
    ?>
    
    <?php require_once("partecipante_studio_navbar.php"); ?>

<?php 
  if( $_SESSION['status'] != 'termina'):  
?>
    <!-- Modal inizio-->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title "><?php echo $obiettivo; ?> </h4>
      </div>
      <div class="modal-body">
        <p> <?php echo $istruzioni; ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>

  </div>
</div>
<?php 
  endif; 
?>

    <div class="embed-responsive embed-responsive-16by9">

       <iframe class="embed-responsive-item"
               src="<?php
                      if( $_SESSION['status'] == 'task' || $_SESSION['status'] == 'questionario'
                          || $_SESSION['status'] == 'termina-noquest') {
                        echo $url;
                      } else if( $_SESSION['status'] == 'termina') {
                        echo 'partecipante_questionario.php';
                      }
                    ?>" allowfullscreen></iframe>

    </div>
 
    <!-- Modal Inizio Studio-->
<div id="modalInizioStudio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Informazioni generali  </h4>
      </div>
      <div class="modal-body">
          <span>All'inizio di ogni task verrà visualizzata una descrizione delle operazioni da effettuare.<br>Una volta eseguiti, cliccare sul tasto &nbsp&nbsp<span class="glyphicon glyphicon-forward"></span><strong>Task successivo</strong><br><br>Nel caso in cui si desideri visualizzare nuovamente il comando da effettuare, premere sul pulsante &nbsp&nbsp<span class="glyphicon glyphicon-info-sign"> </span><strong> Info</strong><br><br>Sarà possibile in qualsiasi momento effettuare l'uscita dallo studio con &nbsp&nbsp<span class="glyphicon glyphicon-log-out"></span><strong> Esci</strong></span> 
      </div>
        <div class="modal-footer">
            <form action="" id="iniziaStudio" method="post">
                <button id="annulla" type="button" class="btn btn-success" data-dismiss="modal"onclick="modalIniziaStudio()">INIZIA</button>
            </form>
      </div>
    </div>
  </div>
</div>
    
    <!-- Modal Studio Terminato-->
<div id="modalStudioTerminato" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Studio terminato</h4>
      </div>
      <div class="modal-body">
           <span>Grazie per aver partecipato a questo studio</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="terminaStudio" method="post">
                <button type="button" class="btn btn-default" onclick="home_partecipante()">ok</button>
            </form>
      </div>
    </div>
  </div>
</div>
    
        <!-- Modal Interrompi Studio-->
<div id="modalInterrompiStudio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Uscire dallo studio?</h4>
      </div>
      <div class="modal-body">
           <span>Interrompendo lo studio non saranno salvati i progressi effettuati fino ad ora.<br>Sei sicuro di voler uscire dallo studio?</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="interrompiStudio" method="post">
                <div class="row">
                    <div class="col-xs-6">
                        <button id="annulla" type="button" class="btn btn-success" data-dismiss="modal">annulla</button>    
                    </div>
                    <div class="col-xs-6">
                        <button type="button" class="btn btn-danger" onclick="partecipante_esci()">esci</button>
                    </div>
                </div> 
            </form>
      </div>
    </div>
  </div>
</div>
    
</body>

</html>