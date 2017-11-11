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
          <a href="#" onclick="modalEsciInvitaPart()"> 
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

<!-- Modal Esci Invita Partecipanti-->
<div id="modalEsciInvitaPart" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Uscire da Invito Partecipanti? </h4>
      </div>
      <div class="modal-body">
           <span>Sei sicuro di voler abbandonare la pagina di invito dei partecipanti?<br>Tutte le eventuali e-mail inserite andranno perse</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="formEsciInvitaPart" method="post">
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
<div id="modalInterrompiStudio" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Eseguire il logout? </h4>
      </div>
      <div class="modal-body">
           <span>Sei sicuro di voler abbandonare la pagina di invito dei partecipanti?<br>Tutte le e-mail inserite andranno perse</span> 
      </div>
        <div class="modal-footer">
            <form action="" id="interrompiStudio" method="post">
                <div class="row">
                    <div class="col-xs-6">
                        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">annulla</button>
                    </div>
                    <div class="col-xs-6">
                        <button id="studioTerminato" type="button" class="btn btn-default" onclick="logout()">esci</button> 
                    </div>
                </div>
            </form>
      </div>
      </div>
  </div>
</div>