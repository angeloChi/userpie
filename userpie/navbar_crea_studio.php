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
        <li>
          <a href="#" onclick="modalEsciStudio()"> 
              <span class="h4">
                <span class="glyphicon glyphicon-home"></span>Home</span>
          </a>
        </li>
        <li>
          <a href="#" onclick="modalLogout()"> 
              <span class="h4">
                <span class="glyphicon glyphicon-off"></span>Logout
              </span>
          </a>
        </li>
      </ul>
    </div>
    </div>
</nav>

<!-- Modal Esci Studio-->
<div id="modalEsciStudio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Uscire dalla creazione dello studio? </h4>
      </div>
      <div class="modal-body">
           <span>Sei sicuro di voler abbandonare la creazione dello studio?<br>Tutti i dati inseriti andranno persi</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="formEsciStudio" method="post">
                <div class="row">
                    <div class="col-xs-6">
                        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">annulla</button>
                    </div>
                     <div class="col-xs-6">
                        <button id="studioTerminato" type="button" class="btn btn-default" onclick="esperto_home()">esci</button>
                     </div>   
                </div>
            </form>    
        </div>
      </div>
  </div>
</div>

<!-- Modal Logout-->
<div id="modalLogout" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Eseguire il logout? </h4>
      </div>
      <div class="modal-body">
           <span>Sei sicuro di voler abbandonare la creazione dello studio?<br>Tutti i dati inseriti andranno persi</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="formLogout" method="post">
                 <div class="row">
                    <div class="col-xs-6">
                         <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">annulla</button>  
                     </div>
                     <div class="col-xs-6">
                         <button id="studioTerminato" type="button" class="btn btn-default" onclick="logout()">esci</button>                        </div>
                </div>                         
            </form>
      </div>
      </div>
  </div>
</div>