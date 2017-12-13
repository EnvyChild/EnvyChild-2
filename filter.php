<?php

class Filter
{
    public $person;
    public $category;
    public $status;

    public function __construct()
    {
        $person = "0";
        $category = "1";
        $status = "2";
    }
    public function set($person, $category, $status)
    {
        $this->person = $person;
        $this->category = $category;
        $this->status = $status;
    }
    public function toString()
    {
        return (isset($this->person) ? ($this->person == null ? 'null' : $this->person) : 'not set').' '
            .(isset($this->category) ? ($this->category == null ? 'null' : $this->category) : 'not set').' '
            .(isset($this->status) ? ($this->status == null ? 'null' : $this->status) : 'not set');
    }
}

?>