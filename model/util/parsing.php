<?php

//Obtenemos los parametros de las queries
function getQueryParams(){
    parse_str($_SERVER['QUERY_STRING'],$query);
    return $query;
}

//Obtenemos los parametros por segmentos de la uri
function getUriSegment(){
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $uri= explode('/', $uri);
    return $uri;
}

?>