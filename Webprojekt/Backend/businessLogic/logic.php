<?php
include("db/dataHandler.php");

class logic{
    private $dh;
    function __construct()
    {
        $this->dh = new dataHandler();
    }

    function handleRequest($method, $param, $payload){
        switch($method){
            case "load":
                $res = $this->dh->load($param, $payload);
                break;
            case "newAppointment":
                $res = $this->dh->save($payload);
                break;
            case "newPeople":
                $res = $this->dh->savePeople($payload);
                break;
            case "delete":
                $res = $this->dh->deleteAppointment($payload);
                break;
            default:
                $res = null;
                break;
        }
        return $res;
    }
}

?>