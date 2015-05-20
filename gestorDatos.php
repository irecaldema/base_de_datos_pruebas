<?php
header('Access-Control-Allow-Origin: *');  

$nombre_tabla=$_POST["n_tabla"];
$campos=$_POST["campos"];

$usuario=$_POST["usuario"];
$contrasena=$_POST["password"];
$nombre_bd=$_POST["n_bd"];

$valores=$_POST["valores"];
$gestion=$_POST["gestion_dato"];

//para pruebas
//$usuario="zubiri";
//$contrasena="";
//$nombre_bd="pruebax";
//$nombre_tabla="prueba_prueba";
//$gestion="mostrar";

/*
INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba2","prueba2@mail",682364822);
INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba3","prueba3@mail",682364833);
INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba4","prueba4@mail",682364844);
INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba5","prueba5@mail",682364855);
INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba6","prueba6@mail",682364866);
*/


$link = mysql_connect('127.0.0.1', $usuario, $contrasena);
if (!$link) {
    die('Could not connect: ' . mysql_error());
    
    $data = '{"error en la conexion a la base de datos"}';
    header('Content-Type: application/json');
    echo json_encode($data);
}else{
    if ($gestion=="mostrar"){
        
        //$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where table_name = prueba_prueba";
        //$nombres_col=mysql_query($sql,$link);
            
        $sql="use $nombre_bd";
        mysql_query($sql,$link);
        $respuesta=$sql="selec * from $nombre_tabla";
        //datos
        //SELECT * FROM `prueba_prueba`
        //nombre columnas
        //SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS
        //where table_name = 'prueba_prueba'
        
        if ($respuesta!=null)	{ 
            
            $nombres_columnas=array();
            
            //$sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where table_name = $nombre_tabla";
            $sql="SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where table_name = 'prueba_prueba'";
            //SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS where table_name = 'prueba_prueba';
            $nombres_col=mysql_query($sql,$link);
            //echo "nombre de tabla: ".$nombre_tabla."<br/>";
            //echo "<br/>";
            //echo "bucle nombres de las columnas:<br/>";
            while ($row = mysql_fetch_assoc($nombres_col)) {
                array_push($nombres_columnas, $row["COLUMN_NAME"]);
                //echo $row["COLUMN_NAME"];
                //echo "<br/>";
            }
            //echo "<br/>";
            
            $max = sizeof($nombres_columnas);
            //echo "tamano array nombre columnas: ".$max."<br/>";
            
            $datos=array();
            $sql="SELECT * FROM $nombre_tabla";
            $respuesta=mysql_query($sql,$link);
            $contador = 0;
            //echo "<br/>";
            //echo "<br/>";            
            //echo "bucle datos  6 filas<br/>";
            while ($row = mysql_fetch_assoc($respuesta)) {
                for($i=0;$i<$max;$i++){
                    //echo "bucle for <br/>";
                    //echo "columna numero: ".$i."<br/>";
                    //echo $nombres_columnas[$i];
                    //echo " valor:  ".$row[$nombres_columnas[$i]];
                    array_push($datos, $row[$nombres_columnas[$i]]);
                    //echo "<br/>";
                    //echo "<br/>";
                    $contador++;
                }    
            }
                    //echo "numero de datos".$contador;
            
            $data = array('columnas' => $nombres_columnas, 'datos' => $datos, 'resultado' => 'ok');
            header('Content-Type: application/json');
        	echo json_encode($data);
    	}
    }else if($gestion=="crear"){
        
        //http://aprenderaprogramar.com/index.php?option=com_content&view=article&id=615:php-insert-into-values-insertar-datos-registros-filas-en-base-de-datos-mysql-ejemplos-y-ejercicio-cu00843b&catid=70:tutorial-basico-programador-web-php-desde-cero&Itemid=193
        
        $sql="use $nombre_bd";
        //$sql="use pruebax";
        mysql_query($sql,$link);
        
        
        //$nombre_tabla="prueba_borrame2";
        //$campos="nombre varchar(20)";
        $sql="insert into $nombre_tabla values ($valores)"; //ok
        //$sql=
        //"INSERT INTO `prueba_prueba`(`ID_Contact`, `Name`, `Email`, `Phone`) VALUES ("","prueba","email",987123654)"; 
        //codigo sql ok
        
        mysql_query($sql,$link);
        $data = array('nombre_tabla' => $nombre_tabla, 'resultado' => 'tabla creada');
        echo $data;
        header('Content-Type: application/json');
        echo json_encode($data);
    }    
    // fin de la conexion
    mysql_close($link);
}
?>