<?php
header('Access-Control-Allow-Origin: *');  
$usuario=$_POST["usuario"];
//$usuario="zubiri";
$contrasena=$_POST["password"];
//$contrasena="";
$nombre_bd=$_POST["n_bd"];
//$nombre_bd="preuba1234";
$gestion=$_POST["gestion_bd"];//"gestion_bd"
//$gestion="mostrar";
$link = mysql_connect('127.0.0.1', $usuario, $contrasena);
if (!$link) {
    die('Could not connect: ' . mysql_error());
    
    $data = '{"error en la conexion a la base de datos"}';
    header('Content-Type: application/json');
    echo json_encode($data);
}else{
    if ($gestion=="mostrar"){
        $sql="show databases";
        
        if (mysql_query($sql,$link)!=null)	{ //para nada
            $respuesta=mysql_query($sql,$link);
            
            /*
            echo "<ul>";
            while ($row = mysql_fetch_assoc($respuesta)) {
                echo "<li>";
                echo $row['Database'];
                echo "</li>";
            }
            echo "</ul>";       //funciona lista de bds
            
            <?php
                $pila = array("naranja", "plátano");
                array_push($pila, "manzana", "arándano");
                print_r($pila);
            ?>
            */
            
            $bds=array();
            
            while ($row = mysql_fetch_assoc($respuesta)) {
                array_push($bds, $row['Database']);
            }
            
            $data = array('respuesta' => $bds, 'resultado' => 'ok');
            header('Content-Type: application/json');
        	echo json_encode($data);
    	}
    }else if($gestion=="crear"){
        $sql="CREATE DATABASE $nombre_bd";
        
        mysql_query($sql,$link);
        $data = array('nombre_bd' => $nombre_bd, 'resultado' => 'base de datos creada');
        header('Content-Type: application/json');
    	echo json_encode($data);
    }
    // fin de la conexion
    mysql_close($link);
}
?>