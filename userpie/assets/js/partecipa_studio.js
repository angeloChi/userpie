/*
La funzione mostra una finestra modale
che contiene la descrizione corrente.
*/
function showModal() {
    $('#myModal').modal('show');
}

function close_tab(){
    window.close();
}

function modalStudioTerminato(){
     $('#modalStudioTerminato').modal('show');
}

function home_partecipante(){
    $( "#terminaStudio" ).attr('action','partecipa_studio_code.php');
    $( "#terminaStudio" ).submit();    
}

function modalInterrompiStudio(){
     $('#modalInterrompiStudio').modal('show');
}

function partecipante_esci(){
    $( "#interrompiStudio" ).attr('action','partecipante_home.php');
    $( "#interrompiStudio" ).submit();    
}

function inizioStudio() {
    $('#modalInizioStudio').modal('show');
}

function modalIniziaStudio(){
     $('#myModal').modal('show');
}

function modalAvviaStudio(idstudio){
    $('#modalAvviaStudio').modal('show');
    $( "#id_studio" ).attr('value',idstudio);
}

