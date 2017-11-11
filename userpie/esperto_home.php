<?php

  require_once("models/config.php");

  /*
  * Uncomment the "else" clause below if e.g. userpie is not at the root of your site.
  */
  if (!isUserLoggedInEsp()) {
      header('Location: login.php');
  }
?>



<!DOCTYPE html>
<html>
<head>
<title>Esperto Home<?php echo $websiteName; ?> </title>
<?php require_once("head_inc.php"); ?>
<script src="assets/js/valuta_studio.js"></script>
<script src="assets/js/esperto_home.js"> </script>
    

</head>
<body
    <?php   
        if(isset($_SESSION["studio_creato"]) && $_SESSION['studio_creato'] == '1'){
            echo "onload=\"showModalStudioCreato()\"";
            $_SESSION['studio_creato'] = '0';
        }else if(isset($_SESSION["partecipanti_invitati"]) && $_SESSION['partecipanti_invitati'] == '1'){
            echo "onload=\"showModalPartecipantiInvitati()\"";
            $_SESSION['partecipanti_invitati'] = '0';
        }
        
    ?> > <!-- chiusura tag body -->
    
    
    <?php require_once("navbar_esperto_Temp.php"); ?>
    
    <div class="container">
    <div class="row">


                 <div class="row">
                     <div class="col-xs-12">
                       <div class="h5 text-right" >esperto: <?php echo $loggedInUser->display_username; ?>
                       &nbsp;</div>
                    </div>
                </div>

              <div class="panel panel-default">
                     <div class="panel-heading"><strong>STUDI CREATI</strong></div>
                     <div class="panel-body">
                      <div class="table-responsive">
                   <table class="table table-hover">
                     <thead id="attributes">
                       <tr>
                         <th>Titolo</th>
                         <th>Descrizione</th>
                         <th>URL</th>
                         <th>Data</th>
                         <th>Opzioni</th>
                       </tr>
                     </thead>
                        <tbody>
                           <?php 
                            $result = $loggedInUser->recupera_studi_esperto();
                            while($row = $db->sql_fetchrow($result)): ?>
                            <tr>
                                <td>
                                    <div class="h5">
                                        <?php echo $row['obiettivo'] ?>
                                    </div>                                
                                </td>
                                <td>
                                    <div class="h5">
                                        <?php echo $row['descrizione'] ?>
                                    </div>                                
                                </td>
                                <td>
                                    <div class="h5">
                                        <?php echo $row['url'] ?>
                                    </div>                                
                                </td>
                                <td>
                                    <div class="h5">
                                        <?php echo $row['data_studio'] ?>
                                    </div>                                
                                </td>
                                <td>
                                    <div class="h5">
                                        <form id="valuta<?php echo $row['id_studio'] ?>" action="" method="post">
                                            <input type="hidden" id="idstudio" name="idstudio" value="<?php echo $row['id_studio'] ?>">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default dropdown-toggle" 
                                                        data-toggle="dropdown" aria-haspopup="true" 
                                                        aria-expanded="false">
                                                    Opzioni  
                                                    <span class="caret">
                                                    </span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="#" onclick="inviteUser('valuta<?php echo $row['id_studio'] ?>')">
                                                            Invita partecipanti
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                     <li class="dropdown-header">Valuta:</li>
                                                    <?php if( $row['flag_audio'] == 1){ ?>
                                                    <li>
                                                        <a href="#" onclick="valutaAudio('valuta<?php echo $row['id_studio'] ?>')">
                                                            Audio
                                                        </a>
                                                    </li>
                                                    <?php } else { ?>
                                                    <li class="disabled">
                                                        <a href="#" >
                                                            Audio
                                                        </a>
                                                    </li>
                                                    <?php } if( $row['flag_video'] == 1){ ?>
                                                    <li>
                                                        <a href="#"  onclick="valutaVideo('valuta<?php echo $row['id_studio'] ?>')">
                                                            Video
                                                        </a>
                                                    </li>
                                                    <?php } else { ?>
                                                    <li class="disabled">
                                                        <a href="#" >
                                                            Video
                                                        </a>
                                                    </li>
                                                    <?php } if( $row['flag_comportamento'] == 1) { ?>
                                                    <li>
                                                        <a href="#" 
                                                           onclick="valutaBehaviour('valuta<?php echo $row['id_studio'] ?>')">
                                                            Attività mouse
                                                        </a>
                                                    </li>
                                                    <?php } else { ?>
                                                    <li class="disabled">
                                                        <a href="#" >
                                                            Attività mouse
                                                        </a>
                                                    </li>
                                                    <?php } if( $row['flag_q_sus'] == 1 || $row['flag_q_aa'] == 1) { ?>
                                                    <li>
                                                        <a href="#" 
                                                           onclick="valutaQuestionario('valuta<?php echo $row['id_studio'] ?>')">
                                                            Questionario
                                                        </a>
                                                    </li>
                                                    <?php } else { ?>
                                                    <li class="disabled">
                                                        <a href="#" >
                                                            Questionario
                                                        </a>
                                                    </li>
                                                  <?php } ?>
                                                </ul>
                                            </div>
                                        </form>                                        
                                    </div>                                
                                </td>
                            
                            </tr>
                            
                           <?php endwhile; ?>
                        </tbody>

                    </table>
                    <div class="br_spaces">
                        <br><br><br><br><br><br><br><br>
                    </div>
                </div>
            </div>
        </div>
     </div>
  </div>
    
    <!-- Modal Studio creato-->
<div id="studio_creato" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Studio creato </h4>
      </div>
      <div class="modal-body">
           <span> Studio creato correttamente</span> 
      </div>
        <div class="modal-footer">
        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">ok</button>
      </div>
    </div>
  </div>
</div> 

       <!-- Modal Partecipanti invitati-->
<div id="partecipanti_invitati" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Partecipanti invitati </h4>
      </div>
      <div class="modal-body">
           <span> I partecipanti sono stati invitati</span> 
      </div>
        <div class="modal-footer">
        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">ok</button>
      </div>
    </div>
  </div>
</div> 
    
</body>
</html>

