<?php

include_once "../util/returnData.php";
include_once "../DB.class.php";
require_once "./model/Auth.php";

$response = json_decode(file_get_contents('php://input'));

__DATA_RETURN($response);

function fnLogin($response){
    $DB = new DB;


    $query = "SELECT 1 AS existe, id, CONCAT(nombre,' ',apellidoPaterno) AS usuario
    FROM usuarios WHERE pass = '{$response->usuario->pass}';";

    $data = $DB->getAll($query);


    if( isset($data[0]['existe']) == "1" ){

        $result['data']  = $data;
        $result['error'] =  false;
        $result['message'] = "El usuario existe";
        

        $_token = Auth::SignIn($result);

        $output['token'] = $_token;
        $output['error'] = false;
    }else{
        $output['error'] = true;
        $output['message'] ="No existe el usuario.";
        $output['query'] = $query;
    }

    echo json_encode($output);

}