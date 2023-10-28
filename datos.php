<?php

require_once ("metodos.php");

// Obtenemos los metodos HTTP que se estan mandando
$metodo = $_SERVER['REQUEST_METHOD'];

    function acciones($metodo)
    {

        $metodos = new Metodos();
        switch ($metodo) {

            
            case 'GET':

                $id = isset($_GET['id']) ? $_GET['id'] : "";
                $columna = isset($_GET['columna']) ? $_GET['columna']: "";
                $pagina = isset($_GET['pagina']) ? $_GET['pagina'] : "";
                $registros = isset($_GET['registros']) ? $_GET['registros'] : "";
                $orden = isset($_GET['orden']) ? $_GET['orden'] : "";


                // -------------------------------- Caso de separadores / --------------------------------------------
                $url = $_SERVER['REQUEST_URI'];
                $dato = explode("/", $url);
                $ID = isset($dato[3]) ? $dato[3] : "";
                echo $ID;

                return Metodos::get($id, $ID, $registros, $pagina, $columna, $orden);
            
            case "POST":
                $body = json_decode(file_get_contents("php://input"), true);

                $nombre = isset($body['nombre']) ? $body['nombre'] : "";
                $apellidoPaterno = isset($body['apellidoPaterno']) ? $body['apellidoPaterno'] : "";
                $apellidoMaterno = isset($body['apellidoMaterno']) ? $body['apellidoMaterno'] : "";
                $rfc = isset($body['rfc']) ? $body['rfc'] : "";

                return Metodos::post($nombre,$apellidoPaterno,$apellidoMaterno,$rfc);

            break;

            case "PUT":
                $body = json_decode(file_get_contents("php://input"), true);

                $nombre = isset($body['nombre']) ? $body['nombre'] : "";
                $apellidoPaterno = isset($body['apellidoPaterno']) ? $body['apellidoPaterno'] : "";
                $apellidoMaterno = isset($body['apellidoMaterno']) ? $body['apellidoMaterno'] : "";
                $rfc = isset($body['rfc']) ? $body['rfc'] : "";
                $id = isset($body['id']) ? $body['id'] : "";

                return Metodos::put($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$id);

            break;

            case "DELETE":


                $id = isset($_GET['id']) ? $_GET['id'] : "";

                return Metodos::delete($id);

            break;

            default:

                echo "Ningun metodo seleccionado";

                break;
        }
    }

echo json_encode(acciones($metodo));