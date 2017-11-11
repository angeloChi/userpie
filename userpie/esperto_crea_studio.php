<?php require_once( "models/config.php"); /* * Uncomment the "else" clause below if e.g. userpie is not at the root of your site. */ if (!isUserLoggedInEsp()) { header( 'Location: login.php'); } ?>

<!DOCTYPE html>
<html lang="it">

<head>

    <?php require_once( 'head_inc.php') ?>

    <link href="assets/css/utassistant-error.css" rel="stylesheet">
    <link href="assets/css/utassistant_general.css" rel="stylesheet">

    <script src="assets/js/crea_studio.js"></script>
    <script src="assets/js/move_pills.js"></script>

</head>

<body onload="hideOther()">
    <?php require_once( 'navbar_crea_studio.php') ?>
    
    <!-- ____________________________________________________________________________________________________________

 TAB PILLS - MENU'-

------------------------------------------------------------------------------------------------------------- -->
    <div class="container">
        <form class="form-horizontal" id="form" name="form" action="crea_studio_code.php" method="post">
            <?php require_once('ecs_tab.php') ?>
<!-- ____________________________________________________________________________________________________________

 TAB PILLS - DEFINISCI TABS -

------------------------------------------------------------------------------------------------------------- -->
            <div class="tab-content">
                <?php require_once('ecs_studio.php') ?>
                <?php require_once('ecs_task.php') ?>
                <?php require_once('ecs_partecipanti.php') ?>
            </div>
            <input id="count-task" type="hidden" name="count-task" value="1">
        </form>        
    </div>  
</body>

</html>