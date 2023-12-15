<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, DELETE");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit(0);
}

class DBManager {


  /**
  * Gestiona la conexión con la base de datos
  */

  private $dbhost = 'localhost';

  private $dbuser = 'root';

  private $dbpass = '';

  private $dbname = 'sistemaspropietarios';

  public function conexion () {

  /**
  * @return object link_id con la conexión
  */

  $link_id = new mysqli($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);

    if ($link_id->connect_error) {

      $arrayError = array("error1"=>($link_id->connect_errno),
                        "error2"=>$link_id->connect_error);
      $error = json_encode($arrayError);
      //echo "Error de Connexion ($link_id->connect_errno) $link_id->connect_error\n";

      header('Location: error_conexion.php?error='.$error);

      //exit;

    } else {
      //echo "Conectado";
      return $link_id;

    }

  }


} ?>