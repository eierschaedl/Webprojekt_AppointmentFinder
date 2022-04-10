<?php
include("models/appointment.php");
class dataHandler{
    public function load(){
        $res = $this->getDemoList();
        return $res;
    }
/*
    private static function getDemoList(){
        $demoList = [
        ];
        return $demoList;
    }
*/
}
?>