
function valutaAudio( idform ) {
    var id = '#'+ idform;
    $(id).attr('action','valuta_audio.php');
    $(id).submit();
    
}

function valutaVideo( idform ) {
    var id = '#'+ idform;
    $(id).attr('action','valuta_video.php');
    $(id).submit();    
}

function valutaBehaviour( idform ) {
    var id = '#'+ idform;
    $(id).attr('action','valuta_behave.php');
    $(id).submit();    
}

function valutaQuestionario( idform ) {
    var id = '#'+ idform;
    $(id).attr('action','valuta_questionario.php');
    $(id).submit();    
}

function inviteUser( idform ) {
    var id = '#'+ idform;
    $(id).attr('action','esp_invita_part.php');
    $(id).submit();    
}