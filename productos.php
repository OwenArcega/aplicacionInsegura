<?php
    header('Content-Type: application/json');

    $server = "localhost";
    $db_username = "admin";
    $db_password = "`x.xWCUtdmn5>V!a{(lS{?PI63(#PU[{";
    $db_name = "user_control";

    $conn = new mysqli($server . ":3390", $db_username, $db_password, $db_name);

    if($conn->connect_error){
        die("Connection failed: " . $conn->connect_error);
    }

    $arr = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $requestBody = file_get_contents('php://input');
        $jsonData = json_decode($requestBody, true);
        
        if ($jsonData !== null) {
            $nombre = $jsonData['nombre'];
            $cantidad = $jsonData['cantidad'];
            $precio = $jsonData['precio'];
            $descripcion = $jsonData['descripcion'];
            $imagen = $jsonData['imagen'];
    
            $sql = "INSERT INTO productos VALUES('','$nombre',$cantidad,$precio,'$descripcion','$imagen');";
            $result = $conn->query($sql);
        
            if($result == true){
                echo json_encode(array('res'=>true));
            }else{
                echo json_encode(array("res"=>false));
                die("". $conn->error);
            }
        } else {
            echo json_encode(array('res' => false));
            die("". $conn->error);
        }
    } else if($_SERVER['REQUEST_METHOD'] == 'GET'){ 
        $sql = "SELECT nombre, cantidad, precio, descripcion, imagen FROM productos;";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            array_push($arr, array("nombre"=>$row["nombre"],"cantidad"=>$row['cantidad'],"precio"=>$row['precio'],"descripcion"=>$row['descripcion'], "imagen"=>$row['imagen']));
        }
        echo json_encode($arr);
        die();
    } else {
        echo json_encode(array('res'=> false));
        die("". $conn->error);
    }