<?php

class User extends QueryBuilder
{
    private $table_name = 'users';
    private $username;
    private $password;
    private $name;

    function __construct()
    {
        parent::__construct($this->table_name);
    }

    public function find($colum, $value)
    {
        return $this->select(['*'])->where($colum, '=', $value)->get();
    }
}