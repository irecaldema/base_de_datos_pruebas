<?php
header('Access-Control-Allow-Origin: *');  

$nombre_tabla=$_POST["n_tabla"];
$campos=$_POST["campos"];

$usuario=$_POST["usuario"];
$contrasena=$_POST["password"];
$nombre_bd=$_POST["n_bd"];
$gestion=$_POST["gestion_tabla"];

//para pruebas
//$usuario="zubiri";
//$contrasena="";
//$nombre_bd="pruebax";
//$gestion="crear";


$link = mysql_connect('127.0.0.1', $usuario, $contrasena);
if (!$link) {
    die('Could not connect: ' . mysql_error());
    
    $data = '{"error en la conexion a la base de datos"}';
    header('Content-Type: application/json');
    echo json_encode($data);
}else{
    if ($gestion=="mostrar"){
        $sql="use $nombre_bd";
        mysql_query($sql,$link);
        $sql="show tables";
        
        if (mysql_query($sql,$link)!=null)	{ //para nada
            $respuesta=mysql_query($sql,$link);
            
            $tablas=array();
            
            /*        
            echo "<ol>";
            while ($row = mysql_fetch_assoc($respuesta)) {
                echo "<li>";
                //echo $row;
                echo $row["Tables_in_".$nombre_bd];         // forma 1
                //echo $row[Tables_in_information_schema]; //  forma 2
                echo "</li>";
            }
            echo "</ol>";
            */
            
            
            while ($row = mysql_fetch_assoc($respuesta)) {
                array_push($tablas, $row["Tables_in_".$nombre_bd]);
            }
            
            $data = array('respuesta' => $tablas, 'resultado' => 'ok');
            header('Content-Type: application/json');
        	echo json_encode($data);
    	}
    }else if($gestion=="crear"){
        $sql="use $nombre_bd";
        //$sql="use pruebax";
        mysql_query($sql,$link);
        
        
        //$nombre_tabla="prueba_borrame2";
        //$campos="nombre varchar(20)";
        $sql="create table $nombre_tabla($campos)"; //ok
        //$sql="create table borrar_tabla(nombre varchar(20))"; //codigo sql ok
        
        mysql_query($sql,$link);
        $data = array('nombre_tabla' => $nombre_tabla, 'resultado' => 'tabla creada');
        header('Content-Type: application/json');
        echo json_encode($data);
    }    
    // fin de la conexion
    mysql_close($link);
}
?>