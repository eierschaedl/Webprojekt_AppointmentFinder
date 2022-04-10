<?php
class appointment {
    public $id;
    public $name;
    public $date_start;
    public $date_end;

    function __construct($id, $name, $date_start, $date_end) {
        $this->id = $id;
        $this->name = $name;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }
}
