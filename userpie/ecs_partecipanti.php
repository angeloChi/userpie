<div id="partecipanti" class="">
    <div class="br_space">
        <br>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="br_space">
                    <br>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Partecipanti Registrati</strong>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead id="attributes">
                                    <tr>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Invita</th>
                                    </tr>
                                </thead>
                                <tbody id="tuples">
                                    <?php
                                        $i=0;
                                        $result = $loggedInUser->recupera_partecipanti_registrati();
                                        while($row = $db->sql_fetchrow($result)):
                                            $i++;
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="h5">
                                                <?php echo $row['username'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h5">
                                                <?php echo $row['email'] ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="h5">
                                                <button type="button" class="btn btn-default btn-xs" id="button<?php echo $i ?>" onclick="invite('<?php echo $i ?>')">invita</button>
                                                <input type="hidden" name="row<?php echo $i ?>" value="<?php echo $row['email']?>">
                                                <input type="hidden" id="row<?php echo $i ?>-bit" name="row<?php echo $i ?>-bit" value="0">
                                            </div>
                                        </td></tr>
                                    <?php
                                        endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <input type="hidden" id="count_registered" name="count_registered" value="<?php echo $i ?>">
                    </div>
                </div>
                <!-- fine panel partecipanti registrati -->
                
            </div>
        </div>
        <!-- fine row -->
         <div class="row">
            <div class="col-xs-12">
                <div class="br_space">
                    <br>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>Partecipanti Non Registrati</strong>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4">
                                <strong>Email</strong>
                            </div>
                            <div class="col-xs-4 col-xs-offset-4"></div>
                        </div>
                        <div class="row clearfix">
                            <div class="col-xs-6">
                                <input id="email" name="email" type="email" class="form-control" placeholder="email" oninput="deleteErrorStatus('email')">
                            </div>
                                <div class="col-xs-2">
                                    <button id="sendmail" type="button" class="btn btn-default fixbutton" onclick="checkAndAdd()">invita</button>
                                </div>
                        </div>
                        <div class="br_space">
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <strong>Elenco </strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <textarea class="form-control" rows="5" id="invited" name="invited" disabled></textarea>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <!-- fine row -->
        <div class="br_spaces">
            <br><br>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <button type="button" class="btn btn-primary" onclick="t2s()">
                    <span class="glyphicon glyphicon-arrow-left">
                    </span>
                    PRECEDENTE
                </button>
            </div>
            <div class="col-xs-8">
            </div>
            <div class="col-xs-2">
                <button type="button" class="btn btn-primary floatbutton" name="creastudio" id="creastudio" onclick="validateAllAndGo()">
                    <span class="glyphicon glyphicon-floppy-disk">
                    </span>
                    <strong class="h4"> Crea</strong>
                </button>
            </div>      
        </div>
        <div class="br_spaces">
            <br>
            <br>
        </div>
    </div>
</div> 


 <!-- Modal creazione studio-->
<div id="Carica" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Creazione studio in corso...</h4>
      </div>
      <div class="modal-body">
           <span id="num_mail"></span> 
        <div class="progress progress-striped active" style="width:500px" >
            <div id="bar" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                <span id="bar2"></span>    
            </div>  
        </div>
      </div>
    </div>
  </div>
</div> 

       <!-- Modal studio creato-->
<div id="StudioCreato" class="modal fade" role="dialog">
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
        <button type="button" class="btn btn-default" data-dismiss="modal">chiudi</button>
      </div>
    </div>
  </div>
</div>  

       <!-- Modal invitare partecipanti-->
<div id="partecipanti_non_invitati" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title ">Partecipanti non Invitati </h4>
      </div>
      <div class="modal-body">
           <span> Non è stato invitato alcun partecipante. Vuoi creare lo stesso lo studio</span> 
      </div>
        <div class="modal-footer">
            <div class="row">
                    <div class="col-xs-6">
                        <button id="annulla" type="button" class="btn btn-default" data-dismiss="modal">annulla</button>
                    </div>
                    <div class="col-xs-6">
                        <button id="prosegui" type="button" class="btn btn-default" data-dismiss="modal" onclick="prosegui_creaStudio()">prosegui</button>
                    </div>
            </div>   
      </div>
    </div>
  </div>
</div> 
