<?php
include("businessLogic/logic.php");

$param = "";
$method = "";
$payload = "";

$logic = new logic();

if($_SERVER['REQUEST_METHOD'] === "POST") {
    if(isset($_POST['data'])) {
        $payload = $_POST['data'];
        $method = $payload['method'];
        $param = $payload['param'];
    };
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