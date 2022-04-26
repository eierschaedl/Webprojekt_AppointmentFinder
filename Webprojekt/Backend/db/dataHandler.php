<?php
include("models/appointment.php");

class dataHandler{
    public function load(){
        $conn = $this->dbaccess();
        $res = $this->getActiveAppointments($conn);
        return $res;
    }
    public function save($payload){
        $payload = $this->checkPayload($payload);
        if($payload === null){
            $res = "bad request - payload";
        }
        else {
            $conn = $this->dbaccess();
            //put stuff to db
            $res = "db write success";
        }
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            new appointment(1, "WEBSC", "Projekt", "Gerald und Jassi", 1),
            new appointment(2, "Testtermin", "debugging", "Jassi", 1)
        ];
        return $demoList;
    }
    private function dbaccess(): mysqli
    {
        $host = $dbusername = $dbpassword = $dbname = "";

        require_once 'db.php';

        //create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        return $conn;
    }

    private function checkPayload($payload){
        //check if everything is alright
    }



    private static function getActiveAppointments($conn): array
    {
        $sql = "SELECT * FROM appoinments WHERE active = 1";
        $result = $conn->query($sql);
        $appointmentList = array(5);
        for($counter = 0; $row = $result->fetch_assoc(); $counter++){
            $appointmentList[$counter] = new appointment($row['appointment_id'],$row['name'],$row['description'],$row['creator'],1);

        }
        return $appointmentList;
    }
}
?>