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
            $usuario = $jsonData['usuario'];
            $total = $jsonData['total'];
    
            $sql = "INSERT INTO compras VALUES('','$usuario',$total);";
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
    } else {
        echo json_encode(array('res'=> false));
        die("". $conn->error);
    }