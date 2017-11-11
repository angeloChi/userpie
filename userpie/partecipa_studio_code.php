<?php

    require_once("models/config.php");

    if (!isUserLoggedInPart()) {
      header('Location: login.php');
    }
    
    $status = $_SESSION['status'];
    switch($status) {
        case 'task':
            $idstudio = $_SESSION['idstudio'];
            $numtasks = $_SESSION['numtasks'];
            $currenttask = $_SESSION['currenttask'] + 1;
            $_SESSION['currenttask'] = $currenttask;
            if($numtasks >= $currenttask) {
                $result = $loggedInUser->getInfoTask($idstudio, $currenttask);
                $_SESSION['idtask'] = $result['id_task'];
                $_SESSION['obiettivo'] = $result['obiettivo'];
                $_SESSION['istruzioni'] = $result['istruzioni'];
                $_SESSION['url'] = $result['url'];
            }
            if($currenttask == $numtasks) {
                if( $_SESSION['flag_q_aa'] == $_SESSION['flag_q_sus'] ) {
                    $_SESSION['status'] = 'termina-noquest';
                } else {
                    $_SESSION['status'] = 'questionario';
                }
            }
            header('Location: partecipante_studio.php');
            break;
            
        case 'questionario':
            $_SESSION['status'] = 'termina';
            header('Location: partecipante_studio.php');
            break;
            
        case 'termina':
            $idstudio = $_SESSION['idstudio'];
            $iduser = $loggedInUser->user_id;			
            $loggedInUser->setFlag($iduser,$idstudio);
            header('Location: partecipante_home.php');
            break;
            
        default:
            header('Location: partecipante_home.php');
            break;
    }
     
?>