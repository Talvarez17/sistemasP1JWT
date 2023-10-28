<?php 

class Conexion {

    public static function connect()
    {
        try {
            $NAMEDB = 'sistemasPropietarios';
            $HOST = 'localhost';
            $USER = 'root';
            $PASSWORD = '';
            return new PDO("mysql:host=$HOST;dbname=$NAMEDB", "$USER", "$PASSWORD");
        } catch (Exception $e) {
            print "¡Error BD!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}

?>