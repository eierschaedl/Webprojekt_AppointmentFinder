<?php
include("models/appointment.php");
class dataHandler{
    public function load(){
        $res = $this->getDemoList();
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            new appointment(1, "Webprojekt", "10.04.2022", "28.04.2022"),
            new appointment(2, "breakfast", "10.04.2022 10:00", "10.04.2022 16:00"),
            new appointment(3, "sleep", "10.04.2022 23:59", "11.04. 2022 09:00"),
        ];
        return $demoList;
    }
}
?>