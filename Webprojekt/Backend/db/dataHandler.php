<?php
include("models/appointment.php");
include("models/dateoption.php");
include("models/people.php");


class dataHandler{
    public function load($param, $payload){
        $conn = $this->dbaccess();
        if($param == "overview") {
            $res = $this->getAppointments($conn);
        }
        else if($param == "details"){
            $res = $this->getDetails($conn, $payload);
        }
        //$this->getDemoList();
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
            $sql = "INSERT INTO appointments (name, description, creator, active) VALUES (?, ?, ?, ?)";
            $query = $conn->prepare($sql);
            $query->bind_param("sssi", $appointment->name, $appointment->description, $appointment->creator, $appointment->active);
            $result = $query->execute();
            $res = "db write success";

            //select newest entry and get id to store with dateOptions
            $sql = "SELECT max(appointment_id) from appointments";
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

    public function savePeople($payload){
        $people = $this->checkPayloadPeople($payload);
        if($people == null){
            $res = "bad request - payload";
        }
        else {
            $conn = $this->dbaccess();
            //put stuff to db
            $sql = "INSERT INTO people (name, comment) VALUES (?, ?)";
            $query = $conn->prepare($sql);
            $query->bind_param("ss", $people->name, $people->comment);
            $query->execute();
            $res = "db write success";

            //select newest entry and get id to store with people_dateoptions
            $sql = "SELECT max(person_id) from people";
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();
            $personID = intval($result["max(person_id)"], 10);

            for ($i = 0; $i < count($payload['chosenOptions']); $i += 1) {
                $dateOption_id = intval($payload['chosenOptions'][$i]);
                $sql = "INSERT INTO people_dateOptions (person_id, dateOption_id) VALUES (?, ?)";
                $query = $conn->prepare($sql);
                $query->bind_param("ii", $personID, $dateOption_id);
                $query->execute();

                $sql = "SELECT votes from dateoptions WHERE dateOptions_id = $dateOption_id";
                $result = $conn->query($sql);
                $result = $result->fetch_assoc();
                $votes = intval($result["votes"], 10);
                $votes += 1;
                $sql = "UPDATE dateoptions SET votes = $votes WHERE dateOptions_id = $dateOption_id";
                $conn->query($sql);
            }
        }

        return $res;
    }

    public function deleteAppointment($payload){
        $conn = $this->dbaccess();

        $id = intval($payload['id']);
        //print_r($id);
        $sql = "DELETE from appointments WHERE appointment_id = $id";
        //in case we misunterstood the grading matrix and this should actually just set appointment to inactive instead of deleting it:
        //$sql = "UPDATE appointments SET active = 0 WHERE appointment_id = $id";

        $conn->query($sql);

        $res = "deleted appointment";
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

    private function checkPayloadPeople($payload){
        //check if everything is alright
        if (!isset($payload['name']) ||
            !isset($payload['comment'])) {
            return null;
        }

        $payload['name'] = $this->test_input($payload['name']);
        $payload['comment'] = $this->test_input($payload['comment']);

        return new people(0, $payload['name'], $payload['comment']);
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
        $sql = "SELECT * FROM appointments";
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

    private static function getDetails($conn, $payload)
    {
        $appointment = [];

        //get appointment details
        $sql = "SELECT * FROM appointments WHERE appointment_id = $payload";
        //var_dump($payload);
        $result = $conn->query($sql);
        //var_dump($result);
        $result = $result->fetch_assoc();
        $result = new appointment($result['appointment_id'],$result['name'],$result['description'],$result['creator'],$result['active']);
        array_push($appointment, $result);

        //get dateoptions
        $sql = "SELECT * FROM dateoptions WHERE fk_appointment_id = $payload";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            $dateoption = new dateoption($row['dateOptions_id'],$row['start'],$row['end'],$row['votes']);
            array_push($appointment, $dateoption);
        }
        //print_r($appointment);
        return $appointment;
    }
}
?>