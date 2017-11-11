<div id="studio" class="">  
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="br_spaces">
                    <br><br>   
                </div>
                <div class="panel panel-default" id="studio">
                    <div class="panel-heading clearfix">
                        <div class="row">
                            <div class="col-xs-6">
                                <span id="title1">
                                    <strong><h3>Definizione Studio</h3></strong>
                                </span>
                            </div>
                            <div class="col-xs-6">
                            </div>                               
                        </div>
                    </div>
                    <div id="studio_body" class="panel-body">
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-11">
                                    <div class="br_space">
                                        <br>
                                    </div>
                                    <div id="titolo_div">
                                        <label for="title">Titolo:</label> 
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Inserire il titolo dello studio" onblur="validateText('title')" onclick="deleteErrorStatus('title')">
                                    </div>
                                    <div class="br_space">
                                        <br>
                                    </div>
                                    <div id="url_div">
                                        <label for="url">URL:</label>
                                        <input id="url" name="url" type="text" class="form-control" placeholder="Es. http://www.esempio.it" onblur="validateURL('url')" onclick="deleteErrorStatus('url')">
                                    </div>
                                    <div class="br_space">
                                        <br>
                                    </div>
                                    <div id="descr_div">
                                        <label for="descrizione">Descrizione: </label>
                                        <textarea id="descrizione" name="descrizione" class="form-control" rows="6" cols="25" onblur="validateText('descrizione')"
                                                  onclick="deleteErrorStatus('descrizione')" placeholder="inserire una descrizione per lo studio"></textarea>
                                    </div>
                                    <div class="br_spaces">
                                    <br><br>   
                                    </div>
                                    <fieldset>
                                        <legend><strong><h4>Input da catturare</h4></strong></legend>
                                        <div><label><h5>Selezionare una o più delle seguenti tipologie di rilevamento dati. In fase di valutazione, i risultati dello studio saranno visualizzati in base ai dati che si desidera raccogliere durante l'esecuzione del test.</h5></label></div>
                                        <div id="recaudio_div">
                                        <input id="recaudio" name="recaudio" type="checkbox">
                                        <label for="recaudio">registra audio</label>
                                        </div>                             
                                        <div id="recvideo_div">
                                            <input id="recvideo" name="recvideo" type="checkbox">
                                            <label for="recvideo">registra video</label>
                                        </div>
                                        <div id="recbehave_div">
                                            <input id="recbehave" name="recbehave" type="checkbox">
                                            <label for="recbehave">registra attività mouse</label>
                                        </div>
                                        <div class="br_space">
                                        <br>
                                        </div>
                                    </fieldset>  
                                    <div class="br_space">
                                        <br>
                                    </div>
                                    <fieldset>
                                        <legend><strong><h4>Questionario da somministrare</h4></strong></legend>
                                        <div class="row clreafix">
                                            <div class="col-xs-10">
                                                <div><label><h5>Selezionare il questionario da somministrare al termine dello studio</h5></label></div>
                                            </div>
                                            <div class="col-xs-2">
                                                <a href="#" onclick="showInfoQuestionari()">
                                                <span class="glyphicon glyphicon-info-sign"><strong class="h4"> Info</strong></span>
                                                </a>
                                            </div>
                                        </div>
                                        
                                        
                                        <div id="attrakdiff_div">
                                            <input id="attrakdiff" name="survey" type="radio" value="attrakdiff">
                                            <label for="attrakdiff">questionario ATTRAKDIFF</label>
                                        </div>
                                        <div id="sus_div">
                                            <input name="survey" type="radio" value="sus">
                                            <label for="sus">questionario SUS</label>
                                        </div>
                                        <div id="none_div">
                                            <input name="survey" type="radio" value="none" checked>
                                            <label for="none">nessun questionario</label>
                                        </div>
                                        <div class="br_space">
                                        <br>
                                        </div>
                                    </fieldset>
                                    <div class="br_space">
                                        <br>
                                    </div>
                                </div>
                            </div>                       
                        </div>                
                    </div>
                </div>
                <!-- Fine panel-default -->             
            </div>
        </div>
        <!-- Fine row -->
        <div class='row'>
            <div class="col-xs-10">
            </div>
            <div class="col-xs-2">
                <div class="br_space">
                    <br>
                </div>
                <button type="button" class="btn btn-primary floatbutton" onclick="f2s()">
                    SUCCESSIVO
                    <span class="glyphicon glyphicon-arrow-right"></span>
                </button>
            </div>
        </div>
        <div class="br_spaces">
            <br><br>
        </div>
    </div>
</div>

<!-- Modal campi incompleti studio-->
<div id="modalErrorStudio" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Informazioni mancanti </h4>
      </div>
      <div class="modal-body">
           <span> Uno o più campi non sono stati compilati. Ricontrollare e proseguire</span> 
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal campi incompleti studio-->
<div id="modalErrorInput" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Informazioni mancanti </h4>
      </div>
      <div class="modal-body">
           <span> Selezionare almeno un input da catturare. Ricontrollare e proseguire</span> 
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div> 

<!-- Modal descrizione questionari-->
<div id="modalInfoQuestionari" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Questionari </h4>
      </div>
      <div class="modal-body">
           <span> Inserire qui la descrizione dei questionari...</span> 
      </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div> 