<?php

class DatabaseConnecting
{
    private $connecting;

     function __construct()
    {
        $this->connection = new MySQLi(DBHOST, DBUSER, DBPASSWORD, DBNAME);
        $this->connection->set_charset('utf8');
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function get()
    {
        return $this->connection;
    }

}