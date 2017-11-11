<?php


class loggedInUser {

  public $email = NULL;
  public $hash_pw = NULL;
  public $user_id = NULL;
  public $clean_username = NULL;
  public $display_username = NULL;
  public $remember_me = NULL;
  public $remember_me_sessid = NULL;

    
  //Simple function to update the last sign in of a user
  public function updatelast_sign_in()
  {
    global $db,$db_table_prefix;

    $sql = "UPDATE ".$db_table_prefix."users
            SET last_sign_in = '".time()."'
            WHERE user_id = '".$db->sql_escape($this->user_id)."'";

    return ($db->sql_query($sql));
  }

  //Return the timestamp when the user registered
  public function signupTimeStamp()
  {
    global $db,$db_table_prefix;

    $sql = "SELECT
        sign_up_date
        FROM ".$db_table_prefix."users
        WHERE user_id = '".$db->sql_escape($this->user_id)."'";

    $result = $db->sql_query($sql);

    $row = $db->sql_fetchrow($result);

    return ($row['sign_up_date']);
  }

  //Update a users password
  public function updatepassword($pass)
  {
    global $db,$db_table_prefix;

    $secure_pass = generateHash($pass);

    $this->hash_pw = $secure_pass;
      if($this->remember_me == 1)
          updateSessionObj();

    $sql = "UPDATE ".$db_table_prefix."users
            SET password = '".$db->sql_escape($secure_pass)."'
            WHERE user_id = '".$db->sql_escape($this->user_id)."'";

    return ($db->sql_query($sql));
  }

  //Update a users email
  public function updateemail($email)
  {
    global $db,$db_table_prefix;

    $this->email = $email;
      if($this->remember_me == 1)
          updateSessionObj();

    $sql = "UPDATE ".$db_table_prefix."users
            SET email = '".$email."'
            WHERE user_id = '".$db->sql_escape($this->user_id)."'";

    return ($db->sql_query($sql));
  }

  //Fetch all user group information.
  public function groupID()
  {
    global $db,$db_table_prefix;

    $sql = "SELECT ".$db_table_prefix."users.group_id, ".$db_table_prefix."groups.*
            FROM ".$db_table_prefix."users INNER JOIN ".$db_table_prefix."groups ON ".$db_table_prefix."users.group_id = ".$db_table_prefix."groups.group_id
            WHERE user_id  = '".$db->sql_escape($this->user_id)."'";

    $result = $db->sql_query($sql);

    $row = $db->sql_fetchrow($result);

    return($row);
  }

  //Is a user member of a group.
  public function isGroupMember($id)
  {
    global $db,$db_table_prefix;

    $sql = "SELECT ".$db_table_prefix."users.group_id, ".$db_table_prefix."groups.* 
            FROM ".$db_table_prefix."users INNER JOIN ".$db_table_prefix."groups ON ".$db_table_prefix."users.group_id = ".$db_table_prefix."groups.group_id
            WHERE user_id  = '".$db->sql_escape($this->user_id)."' AND
            ".$db_table_prefix."users.group_id = '".$db->sql_escape($db->sql_escape($id))."' LIMIT 1";

    if(returns_result($sql))
      return true;
    else
      return false;

  }

  //recupera query contenente gli studi appartenenti ad un determinato esperto.
  public function recupera_studi_esperto()
  {
    global $db,$db_table_prefix;

        $sql = "SELECT ".$db_table_prefix."id_studio, obiettivo, descrizione,url, data_studio,
                       flag_audio, flag_video, flag_comportamento, flag_q_sus, flag_q_aa
                FROM utassistantdb.studio
                WHERE studio.id_esperto =".$this->user_id;


    return ($db->sql_query($sql));
  }

    
  //Logout.
  function userLogOut()
  {
    destorySession("userPieUser");
  }
    

  //recupera query contenente gli studi appartenenti ad un determinato partecipante.
  public function recupera_studi_partecipante() {
      global $db,$db_table_prefix;

        $sql = "SELECT studio.id_studio, obiettivo, descrizione
                FROM studio INNER JOIN  ass_studio_users
                ON studio.id_studio = ass_studio_users.id_studio
                WHERE ass_studio_users.id_utente =".$this->user_id." AND flag_completato = 0";


    return ($db->sql_query($sql));
  }    


//recupera query contenente i partecipanti gia' registrati.
  public function recupera_partecipanti_registrati()
  {
    global $db,$db_table_prefix;

       $sql = "SELECT username, email 
               FROM users JOIN groups ON users.group_id = groups.group_id
               WHERE groups.group_name = 'p';";

    return ($db->sql_query($sql));
  }
    
  /*
    Recupera tutti gli utenti non invitati precedentemente allo studio
  */
  public function retrieve_uninvited_user( $study ) {
     global $db,$db_table_prefix;

       $sql = "SELECT username, email 
               FROM groups INNER JOIN  users 
               ON users.group_id = groups.group_id
               WHERE groups.group_name = 'p' AND users.user_id NOT IN 
               ( SELECT ass_studio_users.id_utente
                 FROM ass_studio_users
                 WHERE ass_studio_users.id_studio = '". $study ."'
               )";

    return ($db->sql_query($sql));
  }


/*
La funzione permette di inserire i dati relativi allo studio.
appena creato.
*/
public function insertStudio($titolo, $descrizione, $url, $flag_head, $flag_value){

  $conn = new mysqli("localhost", "root", "", "utassistantdb");

  if(!$conn->connect_errno){
    $query_sql = "INSERT INTO `studio` (`obiettivo`, `descrizione`, `url`, `id_esperto`".$flag_head.")
                  VALUES ('".$titolo."', '".$descrizione."', '".$url."', '".$this->user_id."'".$flag_value.")";
    $result = $conn->query($query_sql);
  }

  $conn->close();

}

  /*
  La funzione interroga il database per ritornare l'id dello studio appena creato.
  dall'esperto.
  */
  public function getIDNuovoStudio(){

    $conn = new mysqli("localhost", "root", "", "utassistantdb");

  if(!$conn->connect_errno){

    $query_sql = "SELECT studio.id_studio
                  FROM utassistantdb.studio
                  WHERE studio.id_esperto = '".$this->user_id."'
                  ORDER BY studio.id_studio DESC LIMIT 1";

    $result = $conn->query($query_sql);
  }

    $conn->close();
     $row = $result->fetch_row();
     return $row[0];

  }
    
  /**
    restituisce il titolo dello studio
  */
  public function getTitoloStudio( $idstudio ) {
      $conn = new mysqli("localhost", "root", "", "utassistantdb");

        if(!$conn->connect_errno){

            $query_sql = "SELECT studio.obiettivo
                  FROM utassistantdb.studio
                  WHERE studio.id_studio = '".$idstudio."'";

    $result = $conn->query($query_sql);
  }

    $conn->close();
    $row = $result->fetch_row();
    return $row[0];
  }

  /*
  La funzione permetti di popolare la tabella dei task assegnati allo studio dall'esperto.
  */
  public function insertNewTask($id_studio, $obiettivo, $istruzioni, $durata, $url){
      
     $conn = new mysqli("localhost", "root", "", "utassistantdb");

    if(!$conn->connect_errno){

     $query_sql = "INSERT INTO task (`id_studio`, `obiettivo`, `istruzioni`, `durata_max`, `url`)
                   VALUES ('".$id_studio."', '".$obiettivo."', '".$istruzioni."', '".$durata."', '".$url."' );";

     $result = $conn->query($query_sql);
  }

    $conn->close();
  }

  /**
   La funzione restituisce il numero di task dello studio in esecuzione.
   */
  public function getNumTask( $idstudio ) {
      $conn = new mysqli("localhost", "root", "", "utassistantdb");
      
      $sql = " SELECT COUNT(*) FROM task WHERE task.id_studio LIKE '%".$idstudio."%'";        
      
      if(!$conn->connect_errno){
         $result = $conn->query($sql);
      }
      $conn->close();
      $row = $result->fetch_row();
      return $row[0];
  }

  /**
   La funzione restituisce le informazioni del task corrente
   */
  public function getInfoTask( $idstudio, $numtask ) {
      // $sql = " SELECT  FROM task WHERE task.id_studio LIKE '%".$idstudio."%'";
      
      $sql = " SELECT id_task, obiettivo, istruzioni, url 
               FROM task 
               WHERE id_studio = '". $idstudio."' 
               ORDER BY id_task ASC
               LIMIT ".($numtask -1).", 1";
      
      $conn = new mysqli("localhost", "root", "", "utassistantdb");
      
      if(!$conn->connect_errno){
         $result = $conn->query($sql);
      }
      $conn->close();
      return $result->fetch_assoc();
  }
/*
La funzione restituisce i valori per le catture
ed i questionari.
*/
public function getStudyFlags($idstudio){
    $conn = new mysqli("localhost", "root", "", "utassistantdb");
    
    $sql = "SELECT flag_audio, flag_video, flag_comportamento, flag_q_aa, flag_q_sus
            FROM `studio`
            WHERE id_studio ='".$idstudio."' ";
    
    if(!$conn->connect_errno){
         $result = $conn->query($sql);
      }
      $conn->close();
      return $result->fetch_assoc();
 }
 
    function setFlag($id_utente, $id_studio){
    $conn = new mysqli("localhost", "root", "", "utassistantdb");

    if(!$conn->connect_errno){

        $sql = "UPDATE ass_studio_users 
            SET flag_completato = 1 ,
                data_completamento = CURRENT_TIMESTAMP()
            WHERE id_utente = ".$id_utente."
            AND id_studio = ".$id_studio." ";
        
        $result = $conn->query($sql);
  }

    $conn->close();
}
    
}
?>
