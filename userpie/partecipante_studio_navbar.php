<?php


?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Logo -->
    <div class="navbar-header">
      <div>
        <a class="navbar-brand">
          <strong class="h2"> UTAssistant </strong>
        </a>
      </div>

        <div>
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mainNavBar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
    </div>

    <!--Voci del menu -->
    <div class="collapse navbar-collapse" id="mainNavBar">        
    <ul class="nav navbar-nav navbar-right">
        <?php if( $_SESSION['status'] != 'termina' ): ?>
          <li>
          <a href="#">
              <span class="h4">
                <span class="glyphicon glyphicon-info-sign"
                      data-toggle="modal" data-target="#myModal"><strong>Info</strong></span></span>
          </a>
        </li>
        <li>
              <a href="#" style="pointer-events: none; cursor: default;">
                <span class="h4">Task <?php echo $currenttask;?>/<?php echo $numtasks;?></span>
                &nbsp;&nbsp;&nbsp;</a>
        </li>
          <?php endif; ?>
          <?php switch ($_SESSION['status']): 
                case 'task': ?>
        <li>
          <a href="partecipa_studio_code.php">
              <span class="h4">
                <span class="glyphicon glyphicon-forward"></span>Task successivo</span>
          </a>
        </li>
        <?php break; case'questionario': ?>  
        <li>
          <a href="partecipa_studio_code.php">
              <span class="h4">
                <span class="glyphicon glyphicon-list-alt"></span>Questionario</span>
          </a>
        </li>          
          <?php break; case'termina':case'termina-noquest': ?>          
        <li>
          <a href="#" onclick="modalStudioTerminato()" >
              <span class="h4">
                <span class="glyphicon glyphicon-stop"></span>Termina Studio</span>
          </a>
        </li>
          <?php break; endswitch; ?>
          
          
        <li>
          <a href="#" onclick="modalInterrompiStudio()" >
              <span class="h4">
                <span class="glyphicon glyphicon-log-out"></span> Esci</span>
          </a>
        </li>
      </ul>
    </div>
    </div>
</nav>