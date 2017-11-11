
//Invito partecipanti gia' registrati
function invite(id) {
  var button = $('#button'+id);
  if(button.text() == 'invita'){
    button.text('cancella');
    $('#row'+id+'-bit').attr('value', 1);
  }else{
     button.text('invita');
    $('#row'+id+'-bit').attr('value', 0);
  }

}

/**
 * Verifica che la mail sia stata inserita e sia ben formata
 */
function checkMail(mail) {
    var r = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,5}$/;
    var check = true;
    if(!r.test(mail)) {
        check = false;
    }
    return check;
}

/**
 * Verifica che la mail sia stata inserita e sia ben formata
 */
function validateMail(id) { 
    var elem = $("#" + id);
    var mail = elem.val();
    var check = checkMail(mail); 
    if ( check ) {
       $("#" + id + "-error").remove();
        elem.removeClass("input-error");
    } else {
        $("#" + id + "-error").remove();
        var msg;
        if (mail == '') {
            msg = 'inserire una mail';
        } else {
            msg = ' mail inserita non è corretta';
        }
        elem.addClass('input-error');
        elem.after($("<label id='" + id + "-error' class='message-error'>" + msg +
                     "</label>"));
    }
    return check;
}

/*
 Elimina lo stato di errore quando il focus torna sull'input
*/
function deleteErrorStatus() {
    $('#email-error').remove();
    $('#email').removeClass('input-error');
}

/**
 * agginge una mail nella textarea
 */
function addmail() {
    var value = $('#email').val();
    var text = $('#invited').text();
    if( text == ""){
      $('#invited').text(text + value);
    }else{
      $('#invited').text(text +"\n"+ value);
    }
    $('#email').val('');
}

/**
  Verifica che la mail sia corretta ed in caso positivo l'aggiunge 
  nella textarea
*/
function checkAndAdd() {
    if( validateMail('email') ) {
        addmail();
    }
}

/**
    verifica che ci sia almeno un partecipante registrato
*/
function checkRegistered() {
    var check = false;
    var ret = false;
    $('[id$=-bit]').each(
        function ( ix ) {
            ret = checkbit( $(this) );
            if( ret ) {
                check = true;
            }
        }
    );
    return check;
}

/**
   verifica che il bit sia uno
*/
function checkbit( elem ){
    var check = false;
    if( elem.val() == 1 ){
        check = true;
    }
    return check;
}

/**
    verifica che ci sia almeno un nuovo utente invitato
*/
function checkInvited() {
    var check = false;
    if( $('#invited').val().length != 0 ) {
        check = true;
    }
    return check;
}
/**
  verifica che ci sia almeno un partecipante invitato e poi
  invia il form
*/
function checkAndSend() {
    
    if( checkRegistered() || checkInvited() ) {
        $('#invited').attr('disabled',false);
        attesaCreaStudio();
        $('#form').attr('action','invita_part_code.php');
        $('#form').submit();
    } else {
        $('#nessun_partecipante').modal('show');
    }   
}

/**
 * permette di visualizzare una modal con il tempo restante durante la creazione dello studio
 */
function attesaCreaStudio(){
    var conta_non_registrati = $('#invited').val().split('\n');
    var num_registrati = $('#count_registered').val();
    var conta_registrati = 0;
    for(i=1; i <= num_registrati; i++){
        if($('#row'+i+'-bit').val() == "1"){
            conta_registrati++;
        }
    }
    var mail_totali = conta_non_registrati.length + conta_registrati;
    $('#Carica').modal('show');
    barraAvanzamento(0,mail_totali);
}
/**
 * gestisce la barra di caricamento durante la creazione dello studio
 */
function barraAvanzamento(conta_mail,mail_totali){
    var bar = $('#bar');
    var bar2 = $('#bar2');
    var text_mail = $('#num_mail');
    conta_mail = conta_mail + 1;
    if(conta_mail <= mail_totali){
        var percentuale = (100/mail_totali)*conta_mail;
        scrolldelay = setTimeout('barraAvanzamento('+ conta_mail + ',' + mail_totali + ')',1500);
        setTimeout('clearTimeout(scrolldelay)',mail_totali * 1500);
        bar.attr('style', "width: " + percentuale + "%;");
        bar2.text("Invio mail... " + parseInt(percentuale) + "%");
        text_mail.text("Invito partecipanti: " + conta_mail + "/" + mail_totali);  
    }
}

function modalEsciInvitaPart(){
    $('#modalEsciInvitaPart').modal('show'); 
}

function esperto_home(){
    $( "#formEsciInvitaPart" ).attr('action','esperto_home.php');
    $( "#formEsciInvitaPart" ).submit();    
}

function modalLogout(){
    $('#modalInterrompiStudio').modal('show'); 
}

function logout(){
    $( "#interrompiStudio" ).attr('action','logout.php');
    $( "#interrompiStudio" ).submit();    
}