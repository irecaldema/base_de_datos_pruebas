<?php
header('Access-Control-Allow-Origin: *'); 

$usuario=$_POST["usuario"];
//$usuario="zubiri";
$contrasena=$_POST["password"];
//$contrasena="";

$link = mysql_connect('127.0.0.1', $usuario, $contrasena);
if (!$link) {
    die('Could not connect: ' . mysql_error());
    
    $data = '{"error en la conexion a la base de datos"}';
    header('Content-Type: application/json');
    echo json_encode($data);
}else{
    $data = array('usuario' => $usuario, 'servidor' => 'online');
    header('Content-Type: application/json');
	echo json_encode($data);
}
	// fin de la conexion
    mysql_close($link);
?>