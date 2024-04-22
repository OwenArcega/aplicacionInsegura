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
            $username = $jsonData['username'];
    
            $sql = "SELECT id,  nombre, correo, contrasena FROM users WHERE nombre = '$username';";
            $result = $conn->query($sql);
        
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()) {
                    echo json_encode(array("id"=>$row["id"],"nombre" => $row["nombre"], "correo" => $row["correo"], "contrasena" => $row["contrasena"]));
                }
            }else{
                echo json_encode(array("res"=>false));
                die("". $conn->error);
            }
        } else {
            echo json_encode(array('res' => false));
            die("". $conn->error);
        }
    } else if($_SERVER['REQUEST_METHOD'] == "PUT"){
        $requestBody = file_get_contents('php://input');
        $jsonData = json_decode($requestBody, true);
    
        if ($jsonData !== null) {
            $username = $jsonData['username'];
            $email = $jsonData['email'];
            $password = $jsonData['password'];
            $id = $jsonData['id'];

            $sql = "UPDATE users SET nombre = '$username', correo = '$email', contrasena = '$password' WHERE id = $id;";
            $result = $conn->query($sql);
        
            if($result == true){
                echo json_encode(array("res"=> true));
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