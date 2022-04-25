<?php
include("models/appointment.php");
class dataHandler{
    public function load(){
        $res = $this->getDemoList();
        return $res;
    }
    public function save(){
        $res = "save to db";
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            new appointment(1, "WEBSC", "Projekt", "Gerald und Jassi", 1),
            new appointment(2, "Testtermin", "debugging", "Jassi", 1)
        ];
        return $demoList;
    }
    private static function dbaccess(){
        //require once here
    }

}
?>