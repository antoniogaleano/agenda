<?php
header("Content-Type: application/json");
$pdo = new PDO("mysql:host=localhost;dbname=agenda","root","");
/*
insert into tbleventos(title, descripcion, color, start, end)values('TEST','TEST DE TEST','#f0021a','2022-03-01 15:00:00','2022-03-01 18:00:00')
*/

$accion = (isset($_GET['accion']))?$_GET['accion']:'leer';
switch($accion){
    case 'leer':
           
            $sentenciaSQL = $pdo ->prepare("SELECT * FROM tbleventos");
            $sentenciaSQL->execute();
            $resultado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
            print_r(json_encode($resultado));
        break;
        case 'agregar':
            //insertar evento
            $sentenciaSQL = $pdo->prepare("insert into tbleventos(title, descripcion, color, start, end) 
                values(:title,:descripcion,:color,:start ,:end)");
            $sentenciaSQL ->execute(array(
                "title"=>$_POST['title'],
                "descripcion"=>$_POST['descripcion'],
                "color"=>$_POST['color'],
                "start"=>$_POST['fecha']." ".$_POST['hora'].":00",
                "end"=>$_POST['fecha']." ".$_POST['hora'].":00"
            ));
            print_r($_POST);
        break;
        case 'borrar':
            $sentenciaSQL =$pdo->prepare("DELETE FROM tbleventos WHERE id = :id");
            $sentenciaSQL->execute(array("id"=>$_POST["id"]));
            print_r($_POST["id"]);
        break;
        case 'actualizar':
            $sentenciaSQL =$pdo->prepare("UPDATE tbleventos SET   title = :title, descripcion = :descripcion, color=:color, start=:start, end=:end WHERE id=:id");
            $sentenciaSQL ->execute(array(
                "title"=>$_POST['title'],
                "descripcion"=>$_POST['descripcion'],
                "color"=>$_POST['color'],
                "start"=>$_POST['fecha']." ".$_POST['hora'].":00",
                "end"=>$_POST['fecha']." ".$_POST['hora'].":00",
                "id"=>$_POST['id']
            ));
            print_r($_POST["id"]);
        break;
}
 

?>