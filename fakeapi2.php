<?php
include_once "./model/util/parsing.php";
include_once "./DB.class.php";
include_once "./model/Auth.php";


// Obtener datos 
$response = file_get_contents('php://input');
$data = json_decode($response);

// Obtiene los headers del navegador
$headers = apache_request_headers(); //Obtiene el token mandado desde el header

//Obtencion de los metodos
$_METODO = $_SERVER['REQUEST_METHOD'];

//Instancia de la base de datos
$DB = new DB;

switch ($_METODO) {
    case 'GET':
        
        // Realizacion de la query
        $query = "SELECT id,nombre,apellidoPaterno,apellidoMaterno,rfc FROM usuarios;";

        //Mandamos la query al metodo getAll de la clase DB
        $res = $DB->getAll($query);

        echo json_encode($res);

    break;
    
    case 'POST':
        //Obtenemos la accion que se va a realizar en base al segmento de la URI
        $URI = getUriSegment();
        $_accion = $URI[3];

        //Switcheo segun la accion que se ha realizado
        switch ($_accion) {
            case 'login':
                
                // Realizacion de la query
                $query = "SELECT 1 AS existe, id, CONCAT(nombre,' ',apellidoPaterno,' ',apellidoMaterno) AS usuario
                FROM usuarios WHERE rfc = '{$data->rfc}' AND pass = '{$data->pass}';";

                //Mandamos la query al metodo getAll de la clase DB
                $res = $DB->getAll($query);

                //Imprimimos el resultado de la query
                // echo json_encode($res);

                //Verificamos que la query sea corecta y generamos el token

                if (isset($res[0]['existe']) && $res[0]['existe'] == 1) {
                    //Agreamos los datos que contendra el token
                    $_token['id'] = $res[0]['id'];
                    $_token['usuario'] = $res[0]['usuario'];

                    //Creamos el token
                    $tokenJWT = Auth::SignIn($_token);
                    
                    //Geneamos el arreglo de salida de la informacion
                    $output['id'] = $res[0]['id'];
                    $output['usuario'] = $res[0]['usuario'];
                    $output['error'] = false;
                    $output['message'] = "Usuario existente";
                    $output['tokenjwt'] = $tokenJWT;

                }else{
                    $output['error'] = true;
                    $output['message'] = "Usuario inexistente";
                }

                //Imprimimos el resultado
                echo json_encode($output);
            
            break;

            case 'register':

                try {

                    //Obtenemos el header de autorizacion con el token en el y eliminamos Bearer por un espacio vacio
                    // $_JWT = str_replace("Bearer ", '', $headers['Authorization']);
                    
                    //Verificamos que el token existe
                    Auth::Check();

                    $nombre = $data->nombre;
                    $apat = $data->apellidoPaterno;
                    $amat = $data->apellidoMaterno;
                    $rfc = $data->rfc;
                    $pass = $data->pass;

                    $res= $DB->insert($nombre,$apat,$amat,$rfc,$pass);

                    echo json_encode($res);

                } catch (Exception $e) {

                    //Mandamos el codigo de error
                    http_response_code(401);

                    //Se imprime el arreglo con el error
                    echo json_encode(
                        array(
                            'error' => true,
                            'message' => "Acceso denegado",
                            'error' => $e->getMessage(),
                        )
                    );
                }

            break;
            
        }

    break;
    
    case 'PUT':
        echo "Se entro al metodo: " . $_METODO;
    break;
    
    case 'DELETE':
        echo "Se entro al metodo: " . $_METODO;
    break;
    
}


?>