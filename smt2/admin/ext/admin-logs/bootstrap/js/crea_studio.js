/**
 * verifica che il testo non sia nullo. se nullo inserisce un messaggio di errore se non
 * presente, se non nullo toglie il messaggio di errore se presente.
 */
function checkText(text) {
    var check = true;
    if( !text ) {
        check = false;
    }
    return check;
}

function validateText(id) {
    var elem = $("#" + id);
    if( checkText( elem.val() ) ) {
        $("#" + id + "-error").remove();
        elem.removeClass("input-error");
    } else {
        if ($("#" + id + "-error").length == 0) {
            elem.addClass('input-error');
            elem.after($("<label id='" + id + "-error' class='message-error'> "
                         + "inserire un valore nel campo"
                         + "</label>"));
        }
    }
}

/**
 * verifica che il valore inserito non sia nullo e rispetti il formato opportuno.
 */
function checkURL( url ) {
    var check = true;
    var r = /((http|https):\/\/|)(www.)?([A-Za-z0-9\-]+\.)+(it|com|org)[//]*/;
    if( !r.test(url) ) {
        check = true;
    }
    return check;
}

function validateURL(id) {
    var elem = $("#" + id);
    var msg = '';
    if( checkURL( elem.val() )) {
        $("#" + id + "-error").remove();
        elem.removeClass("input-error");
    }else {
        if (elem.val() == '') {
            msg = 'inserire un URL';
        } else {
            msg = ' URL inserita non è corretta';
        }
        if( $("#" + id + "-error").length != 0){
            $("#" + id + "-error").remove();
        }
        elem.addClass('input-error');
        elem.after($("<label id='" + id + "-error' class='message-error'> "
                     + msg + "</label>"));
    }
}

/**
 *
 */
function checkNumber( number ) {
    var check = true;
    if(number == '' ) {
        check = false;
    }
    return check;
}
/**
 *
 */
function validateNumber(id) {
    var elem = $("#" + id );
    if( !checkNumber( elem.val())){
        if ($("#" + id + "-error").length == 0) {
            elem.addClass('input-error');
            elem.after($("<label id='" + id + "-error' class='message-error'> "
                     + " inserire un valore nel campo</label>"))
        }
    } else {
        $("#" + id + "-error").remove();
        elem.removeClass("input-error");
    }
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
    $("#sendmail").attr('disabled', true);
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
    if (checkMail(mail)) {
       $("#" + id + "-error").remove();
        elem.removeClass("input-error");
        $("#sendmail").removeAttr('disabled');
    } else {
        $("#sendmail").attr('disabled');
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
}
/**
 * allega al controllo in input un evento in base al tipo
 * di valore che esso può contenere
 */
function addcheck( elem, type ) {
    var func = "";
    if( type == "text") {
        func = "validateText('" + elem.attr('id') + "');";
    } else if( type == "number") {
        func = "validateNumber('" + elem.attr('id') + "');";
    } else if( type =="url") {
        func = "validateURL('" + elem.attr('id') + "');";
    }
    elem.attr("onblur",func);
}

/**
 * la funzione imposta per il task gli attributi dell'elemento con attr, newattr
 */
function setElem(task, attr, newattr, type) {
    var elem = task.find("[name=" + attr + "]");
    elem.attr('name', newattr);
    elem.attr('id', newattr);
    elem.val("");
    addcheck( elem, type );

}

/**
 *  la funzione aggiunge nel form  i campi opportuni per il nuovo task
 */
function addTaskForm() {
    if( $("[id$=error]").length != 0) {
        alert('completare i precedenti task');
    }else {
        var counter = $("#count-task");
        var actual = Number(counter.attr('value'));
        var future = actual + 1;
        counter.attr('value', future);

        var task = $("#task" + actual);
        var newtask = task.clone();
        newtask.attr('id', "task" + future);

        //rinomino i campi name ed id per gli elementi del nuovo task incrementati di 1
        setElem(newtask, "obiettivo" + actual, "obiettivo" + future, "text");
        setElem(newtask, "durata" + actual, "durata" + future, "number");
        setElem(newtask, "url" + actual, "url" + future, "url");
        setElem(newtask, "descrizione" + actual, "descrizione" + future, "text");

        //inserisce dopo l'ultimo task il nuovo task creato
        task.after(newtask);

        //inserisce dopo l'ultimo task la label del nuovo task e l'input hidden di riferimento per il controlloDati
        task.after($("<br><br><label><strong class=\"h4\">Definisci Task " + future + " </strong></label>"));

        var w = window.screen.width;
        var h = window.screen.height;
        window.scrollTo(w * h, w * h);
    }

}

/**
 * verifica che tutti i campi siano stati inseriti correttamente
 */
function validateAllAndGo() {
    var numTask = $('#count-task').val();
    var check = true;

    if( !checkText($('#title').val()) || !checkURL($('#url').val()) ||
        !checkText($('#descrizione').val()) ) {
        check = false;
        alert('Le informazioni sullo studio non sono state definite correttamente.');
    }
    for( var i = 1; numTask >= i; i++ ) {
        if( !checkText($('#obiettivo1').val()) || !checkNumber($('#durata1').val())
           || !checkURL($('#url1').val()) || !checkText($('#descrizione1').val())) {
            check = false;
            alert('Le informazioni sul task' + i + ' non sono state definite correttamente.');
        }
    }
    var check_ri = false;
    $('[id$=-bit]').each(
        function(){
          if( $(this).val() == '1'){
           check_ri = true;
        }
        }
    );

    var chech_ni = false;
    if ($("#invited").val().length != 0 ) {
        check_ni = true;
    }

    if ( !check_ri && !check_ni ) {
        alert('invitare almeno un partecipante');
    }

    //invocazione codice php
    if (check && ( check_ri || check_ni ) ) {
    $('#invited').attr('disabled',false);
       $( "#form" ).submit();
    }
}

//Invito partecipanti gia' registrati
function invite(id){
  var button = $('#button'+id);
  if(button.text()=='invita'){
    button.text('cancella');
    $('#row'+id+'-bit').attr('value', 1);
  }else{
     button.text('invita');
    $('#row'+id+'-bit').attr('value', 0);
  }

}

/*
Previene azioni dopo il click sulle tab.
*/

$('.tab_link').click(function(event) {
    event.preventDefault();
});


