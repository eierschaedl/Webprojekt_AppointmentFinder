<?php
class dateoption {
    public $id;
    public $start;
    public $end;
    public $votes;

    function __construct($id, $start, $end, $votes) {
        $this->id = $id;
        $this->start = $start;
        $this->end = $end;
        $this->votes = $votes;
    }
}