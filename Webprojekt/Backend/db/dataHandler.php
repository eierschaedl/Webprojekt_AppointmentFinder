<?php
include("models/appointment.php");

class dataHandler{
    public function load(){
        $conn = $this->dbaccess();
        $res = $this->getActiveAppointments($conn);
        $this->getDemoList();
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
            $sql = "INSERT INTO appoinments (name, description, creator, active) VALUES (?, ?, ?, ?)";
            $query = $conn->prepare($sql);
            $query->bind_param("sssi", $payload->name, $payload->description, $payload->creator, $payload->active);
            $result = $query->execute();
            $res = "db write success";
        }
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            new appointment(1, "WEBSC", "Projekt", "Gerald und Jassi", 1),
            new appointment(2, "Testtermin", "debugging", "Jassi", 1)
        ];
        var_dump($demoList);
        return $demoList;
    }
    private function dbaccess()
    {
        $host = $dbusername = $dbpassword = $dbname = "";

        require_once 'db.php';

        //create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        return $conn;
    }

    private function checkPayload($payload){
        //check if everything is alright
        $payload->name = $this->test_input($payload->name);
        $payload->description = $this->test_input($payload->description);
        $payload->creator = $this->test_input($payload->creator);

        if (!isset($payload->name) ||
            !isset($payload->description) ||
            !isset($payload->creator)) {
            return null;
        }
        $payload = new appointment(null, $payload->name, $payload->description, $payload->creator, 1);
        return $payload;
    }

    private function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    private static function getActiveAppointments($conn)
    {
        $sql = "SELECT * FROM appoinments WHERE active = 1";
        $result = $conn->query($sql);
        var_dump($result);
        $appointmentList = [];
        $counter = 0;
        while($row = $result->fetch_assoc()){
            $appointmentList[$counter] = new appointment($row['appointment_id'],$row['name'],$row['description'],$row['creator'],1);
            var_dump($appointmentList);
            $counter++;
        }
        return $appointmentList;
    }
}
?>