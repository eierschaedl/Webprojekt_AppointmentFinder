<?php
include("db/dataHandler.php");

class logic{
    private $dh;
    function __construct()
    {
        $this->dh = new dataHandler();
    }

    function handleRequest($method, $param){
        switch($method){
            case "load":
                $res = $this->dh->load();
                break;
            //cases using param blabla to be cont'd
            default:
                $res = null;
                break;
        }
        return $res;
    }
}

?>