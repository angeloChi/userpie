<div id="task" class="">
    <div class="br_space">
        <br>
    </div>
    <div class="container">
        <!-- task uno -->
        <div id="row1" class="row">
            <div class="col-xs-12">
                <div class="br_space">
                <br>
                </div>
                <div id="task1" class="panel panel-default">
                    <div id="head_task1" class="panel-heading clearfix">
                        <div class="row">
                            <div class="col-xs-9">
                                <span id="title1">
                                    <strong><h3>Task 1</h3></strong>
                                </span>
                            </div>
                            <div class="col-xs-3">
                            <button type="button" class="btn btn-default floatbutton glyphicon glyphicon-trash"
                                    id="delete1" onclick="alertEliminaTask('row1')">&nbsp;elimina</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" id="body_task1">
                        <div class="br_space">
                            <br>
                        </div>
                        <div id="form-group">
                            <label>Obiettivo:</label>
                            <input id="obiettivo1" name="obiettivo1" type="text" class="form-control" placeholder="Specificare l'obiettivo del task" onblur="validateText( 'obiettivo1' )"
                                   onclick="deleteErrorStatus('obiettivo1')">
                        </div>
                        <div class="br_space">
                            <br>
                        </div>
                        <div id="form-group">
                            <label>Durata stimata (minuti):</label>
                            <input id="durata1" name="durata1" type="number" class="form-control" onblur="validateNumber( 'durata1' )" placeholder="es. 1"
                                   onclick="deleteErrorStatus('durata1')">
                        </div>
                        <div class="br_space">
                            <br>
                        </div>
                        <div id="form-group">
                            <label>URL:</label>
                            <input id="url1" name="url1" type="text" class="form-control" placeholder="http://www.esempio.it" onblur="validateURL( 'url1' )"
                                   onclick="deleteErrorStatus('url1')">
                        </div> 
                        <div class="br_space">
                            <br>
                        </div>
                        <div id="form-group">
                                <label>Descrizione:</label>
                                <textarea id="descrizione1" name="descrizione1" class="form-control" rows="6" cols="25" onblur="validateText( 'descrizione1' )" placeholder="Descrivere le istruzioni del task" onclick="deleteErrorStatus('delete1')"></textarea>
                        </div>
                        <div class="br_space">
                            <br>
                        </div>
                    </div>
                </div>
                <!-- sfasamento -->
            </div>
        </div>
        <!-- fine task uno -->
        <div class="row">
            <div class="col-xs-10">
            </div>
            <div class="col-xs-2">   
                <button type="button" class="btn btn-success floatbutton" onclick="addTaskForm()">
                    <span class="glyphicon glyphicon-plus">
                        <strong class="h4"> Task </strong>
                    </span>                       
                </button>
            </div>
        </div>
        <div class="br_spaces">
            <br>
            <br>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <button type="button" class="btn btn-primary" onclick="s2f()">
                    <span class="glyphicon glyphicon-arrow-left"></span> PRECEDENTE
                </button>
                </div>
                <div class="col-xs-8">
                </div>
                <div class="col-xs-2">
                    <button type="button" class="btn btn-primary floatbutton" onclick="s2t()">
                        SUCCESSIVO
                        <span class="glyphicon glyphicon-arrow-right"></span>
                    </button>
                </div>
        </div>  
        <div class="br_spaces">
            <br>
            <br>
        </div>
    </div>
</div>

<!-- Modal campi incompleti task-->
<div id="modalErrorTask" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Informazioni mancanti </h4>
      </div>
      <div class="modal-body">
           <span> Uno o più campi non sono stati compilati. Compilare i campi per poter proseguire</span> 
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal campi incompleti nell'ultimo task-->
<div id="modalErrorAggiuntaTask" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Informazioni mancanti </h4>
      </div>
      <div class="modal-body">
           <span> Uno o più campi non sono stati compilati. Compilare i campi per poter aggiungere un altro Task </span> 
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal conferma elimina task-->
<div id="modalEliminaTask" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Elimina Task </h4>
      </div>
      <div class="modal-body">
          <span id="modalNumeroTask"> Sei sicuro di voler eliminare il task? </span>
         
      </div>
        <div class="modal-footer">
        <button id="proseguiEliminaTask" type="button" class="btn btn-default" data-dismiss="modal" onclick="#">prosegui</button>
        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">annulla</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal unico task rimasto-->
<div id="modalUnicoTask" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Unico Task rimasto </h4>
      </div>
      <div class="modal-body">
           <span> Non si possono eliminare tutti i task. Lo studio deve avere almeno un task assegnato </span> 
      </div>
        <div class="modal-footer">
        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">ok</button>
      </div>
    </div>
  </div>
</div> 