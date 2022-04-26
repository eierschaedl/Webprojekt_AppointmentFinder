<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>to do list</title>
</head>

<body>
<div class="container">
    <h1>WEBSC2 Appointment Finder</h1>
    <div class="row">
        <div id="newAppointment">
            <h2>neues Event erstellen</h2>
            <form id="appointmentForm">
                <div class="form-group">
                    <label for="name">Name des Events</label><br>
                    <input id="name" name="name" type="text" maxlength="255" required class="form-control"><br>
                    <label for="description">Kurzbeschreibung</label><br>
                    <textarea id="description" name="description" maxlength="1000" required class="form-control"></textarea><br>
                    <label for="creator">Wer erstellt dieses Event?</label><br>
                    <input id="creator" name="creator" type="text" maxlength="255" required class="form-control"><br>
                    <p>Terminoptionen</p>
                    <div class="row">
                        <div class="col" id="start">
                            <label for="start">Start</label>
                            <input type="datetime-local" id="0" name="0" required class="form-control">
                        </div>
                        <div class="col" id="end">
                            <label for="end">Ende</label>
                            <input type="datetime-local" id="1" name="1" required class="form-control">
                        </div>
                    </div>
                    <br>
                    <button id="moreOptions" class="btn btn-outline-dark">weitere Terminoption hinzufügen</button>
                </div>
                <br>
                <input type="submit" id="submit" value ="hinzufügen" class="btn btn-outline-success"></input>
                <button id="cancel" class="btn btn-outline-danger">abbrechen</button>
            </form>
        </div>
        <!--
        <div class="col btn-group">
            <button id="visibility" type="button" class="btn btn-outline-dark">hide</button>
            <button id="edit" type="button" class="btn btn-outline-dark">edit</button>
            delete function implemented but not accessible for user because anarchy
        </div>
        -->
        <div class="col-6"></div>
    </div>

    <div id="appointmentList">
        <h2>Event Übersicht</h2>
        <div class="col">
            <!--<input type="text" id="item" class="form-control">-->
            <button id="add" type="button" class="btn btn-outline-dark">Event hinzufügen</button>
        </div>
        <p>drag and drop um Reihenfolge zu ändern</p>
        <ol id="sortable">

        </ol>
    </div>
</div>
<?php
/*
echo "dataHandler";
include "../Backend/db/dataHandler.php";
echo "logic";
include "../Backend/businessLogic/logic.php";
echo "serviceHandler";
include "../Backend/serviceHandler.php";
*/
?>

<script src="controller.js"></script>
</body>

</html>