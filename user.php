<?php

class User
{
    public $username;
    public $email;
    public $pass;
    public $id;

    public function __construct()
    {
        $username = "0";
        $email = "1";
        $pass = "2";
        $id = "3";
    }
    public function set($username, $email, $pass, $id)
    {
        $this->username = $username;
        $this->email = $email;
        $this->pass = $pass;
        $this->id = $id;
    }
    public function toString()
    {
        return (isset($this->username) ? ($this->username == null ? 'null' : $this->username) : 'not set').' '
            .(isset($this->email) ? ($this->email == null ? 'null' : $this->email) : 'not set').' '
            .(isset($this->pass) ? ($this->pass == null ? 'null' : $this->pass) : 'not set');
    }
}

?>