/**
 Nasconde tutte le tab tranne la prima
*/
function hideOther() {
    $('#task').hide();
    $('#partecipanti').hide();
}
/**
  Questa funzione controlla che tutte le informazioni della prima tab
  siano corrette. Se vi sono errori, avvisa l'utente. Altrimenti,
  attiva la seconda tab e disattiva la prima.
 */
function f2s() {
    if(checkInput()){
        if(checkStudio()){
            $('#studio').hide();
            $('.first-pill').removeClass('ut-pill-active');
            $('.first-pill').addClass('ut-pill-inactive');
            $('.second-pill').removeClass('ut-pill-inactive');
            $('.second-pill').addClass('ut-pill-active');
            $('#task').show();
            window.scrollTo(0, 0);
        }else{
            $('#modalErrorStudio').modal('show');
        }
    }else{
        $('#modalErrorInput').modal('show');
    }
}

function s2f() {
    $('#task').hide();
    $('.second-pill').removeClass('ut-pill-active');
    $('.second-pill').addClass('ut-pill-inactive');
    $('.first-pill').removeClass('ut-pill-inactive');
    $('.first-pill').addClass('ut-pill-active');
    $('#studio').show();
    window.scrollTo(0, 0);

}

function s2t() {
    if(checkTask()){
        $('#task').hide();
        $('.second-pill').removeClass('ut-pill-active');
        $('.second-pill').addClass('ut-pill-inactive');
        $('.third-pill').removeClass('ut-pill-inactive');
        $('.third-pill').addClass('ut-pill-active');
        $('#partecipanti').show();
        window.scrollTo(0, 0);
    }else{
         $('#modalErrorTask').modal('show');
    }
}

function t2s() {
    $('#partecipanti').hide();
    $('.third-pill').removeClass('ut-pill-active');
    $('.third-pill').addClass('ut-pill-inactive');
    $('.second-pill').removeClass('ut-pill-inactive');
    $('.second-pill').addClass('ut-pill-active');
    $('#task').show();
    window.scrollTo(0, 0);

}