<?php
    /* eliminazione di tutte le sessioni utilizzate nel corso
       dell'esecuzione dello studio. '*/
    unset($_SESSION['status']);
    unset($_SESSION['idstudio']);
    unset($_SESSION['numtasks']);
    unset($_SESSION['currenttask']);
    unset($_SESSION['idtask']);
    unset($_SESSION['obiettivo']);
    unset($_SESSION['istruzioni']);
    unset($_SESSION['url']);
    unset($_SESSION['flag_q_aa']);
    unset($_SESSION['flag_q_sus']);
    unset($_SESSION['flag_audio']);
    unset($_SESSION['flag_video']);
    unset($_SESSION['flag_comportamento']);
    header('location: logout.php');
?>