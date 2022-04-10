<?php
class appointment {
    public $id;
    public $name;
    public $description;
    public $creator;
    public $active;

    function __construct($id, $name, $description, $creator, $active) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->creator = $creator;
        $this->active = $active;
    }
}
