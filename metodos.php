<?php 

require ("conexion.php");



class Metodos {

    public static function get($id, $ID, $registros, $pagina, $columna, $orden)
    {

        if ($id !=NULL || $ID != NULL) {

            $con = Conexion::connect();
            $sql = "SELECT * FROM 55tp5_simulaciones WHERE sml_id = ? ?;";
            $sql = $con->prepare($sql);
            $sql->bindValue(1, $id);
            $sql->bindValue(2, $ID);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);

        } else {
            
            $con = Conexion::connect();
            $sql = "CALL getRegistros(". $registros . "," .$pagina . "," . $columna . "," . $orden . ");";
            $sql = $con->prepare($sql);
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_OBJ);
        }
        
    }

    public static function put($nombre,$apellidoPaterno,$apellidoMaterno,$rfc,$id)
    {
        $conectar = Conexion::connect();
        $sql = "UPDATE usuarios SET nombre= ?, apellidoPaterno= ?, apellidoMaterno= ?, rfc= ?  WHERE id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $apellidoPaterno);
        $sql->bindValue(3, $apellidoMaterno);
        $sql->bindValue(4, $rfc);
        $sql->bindValue(5, $id);
        $resultado['estatus'] = $sql->execute();
        return $resultado;
        
    }

    public static function post($nombre,$apellidoPaterno,$apellidoMaterno,$rfc)
    {
        $conectar = Conexion::connect();
        $sql = "INSERT INTO usuarios (nombre, apellidoPaterno, apellidoMaterno, rfc) VALUES (?,?,?,?);";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $nombre);
        $sql->bindValue(2, $apellidoPaterno);
        $sql->bindValue(3, $apellidoMaterno);
        $sql->bindValue(4, $rfc);
        $resultado['estatus'] =  $sql->execute();
        return $resultado;
        
    }

    public static function delete($id)
    {
        $conectar = Conexion::connect();
        $sql = "DELETE FROM usuarios WHERE id = ?;";
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $id);
        $resultado['estatus'] = $sql->execute();
        return $resultado;
    }

}



?>