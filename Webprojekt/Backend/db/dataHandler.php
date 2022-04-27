<?php
include("models/appointment.php");

class dataHandler{
    public function load(){
        $conn = $this->dbaccess();
        $res = $this->getAppointments($conn);
        $this->getDemoList();
        return $res;
    }
    public function save($payload){
        $appointment = $this->checkPayload($payload);
        if($appointment == null){
            $res = "bad request - payload";
        }
        else {
            $conn = $this->dbaccess();
            //put stuff to db
            $sql = "INSERT INTO appoinments (name, description, creator, active) VALUES (?, ?, ?, ?)";
            $query = $conn->prepare($sql);
            $query->bind_param("sssi", $appointment->name, $appointment->description, $appointment->creator, $appointment->active);
            $result = $query->execute();
            $res = "db write success";

            //select newest entry and get id to store with dateOptions
            $sql = "SELECT max(appointment_id) from appoinments";
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();
            $appointmentID = intval($result["max(appointment_id)"], 10);
            $votes = 0;
            for ($i = 0; $i < count($payload['dateoptions']); $i +=2) {
                $sql = "INSERT INTO dateoptions (start, end, votes, fk_appointment_id) VALUES (?, ?, ?, ?)";
                $query = $conn->prepare($sql);
                $query->bind_param("ssii", $payload['dateoptions'][$i], $payload['dateoptions'][$i+1], $votes, $appointmentID);
                $query->execute();
            }
        }
        return $res;
    }

    private static function getDemoList(){
        $demoList = [
            new appointment(1, "WEBSC", "Projekt", "Gerald und Jassi", 1),
            new appointment(2, "Testtermin", "debugging", "Jassi", 1)
        ];
        //var_dump($demoList);
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
        if (!isset($payload['name']) ||
            !isset($payload['description']) ||
            !isset($payload['creator'])) {
            return null;
        }

        $payload['name'] = $this->test_input($payload['name']);
        $payload['description'] = $this->test_input($payload['description']);
        $payload['creator'] = $this->test_input($payload['creator']);

        return new appointment(0, $payload['name'], $payload['description'], $payload['creator'], 1);
    }

    private function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    private static function getAppointments($conn)
    {
        $sql = "SELECT * FROM appoinments";
        $result = $conn->query($sql);
        //var_dump($result);
        $appointmentList = [];
        $counter = 0;
        while($row = $result->fetch_assoc()){
            $appointmentList[$counter] = new appointment($row['appointment_id'],$row['name'],$row['description'],$row['creator'],$row['active']);
            //var_dump($appointmentList);
            $counter++;
        }
        return $appointmentList;
    }
}
?>