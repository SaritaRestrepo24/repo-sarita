<?php
$host="localhost";
$bd="entradas web";
$usuario="root";
$contrasenia="";

try {
        $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contraseña);
        /* if($conexion){ echo "Conectado... a sistema ";}  */
} catch ( Exception $ex) {

    echo $ex->getMessage();

}
?>
