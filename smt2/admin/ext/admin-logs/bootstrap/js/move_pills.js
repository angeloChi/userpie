
/**
  Questa funzione controlla che tutte le informazioni della prima tab
  siano corrette. Se vi sono errori, avvisa l'utente. Altrimenti,
  attiva la seconda tab e disattiva la prima.
 */
function f2s() {
    //codice di controllo
    
    //cambio pill
    $('#studio').removeClass('in active');
    $('.second-pill a').attr('href','#task');
    $('.nav-pills a[href="#task"]').tab('show');
    $('.second-pill a').attr('href','#');

}

function s2f() {
    //codice di controllo
    
    //cambio pill
    $('#task').removeClass('in active');
    $('.first-pill a').attr('href','#studio');
    $('.nav-pills a[href="#studio"]').tab('show');
    $('.first-pill a').attr('href','#');

}

function s2t() {
    //codice di controllo
    
    //cambio pill
    $('#task').removeClass('in active');
    $('.third-pill a').attr('href','#partecipanti');
    $('.nav-pills a[href="#partecipanti"]').tab('show');
    $('.third-pill a').attr('href','#');

}

function t2s() {
    //codice di controllo
    
    //cambio pill
    $('#partecipanti').removeClass('in active');
    $('.second-pill a').attr('href','#task');
    $('.nav-pills a[href="#task"]').tab('show');
    $('.second-pill a').attr('href','#');

}