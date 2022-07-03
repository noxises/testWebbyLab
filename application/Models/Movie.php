<?php

class Movie extends QueryBuilder
{
    private $table_name = 'movie';
    private $title;
    private $year;
    private $format;
    private $actors;

    function __construct()
    {
        parent::__construct($this->table_name);
    }

    public function find($colum, $value)
    {
        return $this->select(['*'])->where($colum, '=', $value)->get();
    }

    public function findLike($colunm, $value)
    {
        return $this->like($colunm, $value)->get();
    }

    public function all()
    {
        return $this->select(['*'])->get();
    }


}