<?php
include("businessLogic/logic.php");

$param = "";
$method = "";
$payload = "";

$logic = new logic();

if($_SERVER['REQUEST_METHOD'] === "POST") {
    isset($_POST["method"]) ? $method = $_POST["method"] : false;
    isset($_POST["param"]) ? $param = $_POST["param"] : false;
    $payload = json_decode(file_get_contents('php://input'));
}
else if($_SERVER['REQUEST_METHOD'] === "GET"){
    isset($_GET["method"]) ? $method = $_GET["method"] : false;
    isset($_GET["param"]) ? $param = $_GET["param"] : false;
    $payload = null;
}
$result = $logic->handleRequest($method, $param, $payload);

if($result == null){
    response("GET", 400, null);
}
else{
    response("GET", 200, $result);
}

function response($method, $httpStatus, $data){
    header('Content-Type: application/json');
    switch($method){
        case "GET":
            http_response_code($httpStatus);
            echo(json_encode($data));
            break;
        default:
            http_response_code(405);
            echo("Method not supported yet :(");
    }
}
?>