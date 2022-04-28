<?php

class people
{
    public $id;
    public $name;
    public $comment;

    function __construct($id, $name, $comment){
        $this->id = $id;
        $this->name = $name;
        $this->comment = $comment;
    }
}
