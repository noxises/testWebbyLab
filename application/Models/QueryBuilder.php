<?php

class QueryBuilder
{

    private $db;
    private $query = '';
    private $table_name;
    private $stmt;
    private $data = array();

    function __construct($table_name)
    {
        $this->db = (new DatabaseConnecting())->get();
        $this->table_name = $table_name;
    }

    public function select($colums)
    {
        $this->query = 'SELECT ' . implode(',', $colums) . ' FROM ' . $this->table_name;
        return $this;
    }


    public function like($column, $value)
    {
        $this->query = 'SELECT * FROM ' . $this->table_name . " WHERE " . $column . " LIKE '%" . $value . "%'";
        return $this;
    }

    public function where($column, $operator, $value)
    {
        array_push($this->data, $value);
        $this->query .= ' WHERE ' . $column . ' ' . $operator . ' ?';
        return $this;
    }

    public function lastId()
    {
        $this->query = 'SELECT LAST_INSERT_ID()';
        return $this->get();
    }

    public function sort($column)
    {
        $this->query = 'SELECT * FROM ' . $this->table_name . ' ORDER BY ' . $column . ' ASC ';
        return $this;
    }

    public function delete($column, $value)
    {
        $this->query = 'DELETE FROM ' . $this->table_name;

        $this->where($column, '=', $value);

        return $this->bind();
    }

    public function insert(array $data)
    {

        $this->data = array_merge($this->data, $data);

        $this->query = 'INSERT INTO ' . $this->table_name . ' VALUES (' . implode(',', array_fill(0, count($data), '?')) . ')';

        return $this->bind();
    }

    private function bind()
    {
        $this->stmt = $this->db->prepare($this->query);

        if ($this->data != null) {
            $params = array();
            array_push($params, $this->getTypes());
            $params = array_merge($params, $this->data);
            foreach ($params as $key => $value) $params[$key] = &$params[$key];
            call_user_func_array(array($this->stmt, 'bind_param'), $params);
        }

        $this->data = array();
        $this->stmt->execute();
        return $this->stmt;
    }

    public function get()
    {
        return mysqli_fetch_all($this->bind()->get_result(), MYSQLI_ASSOC);
    }

    private function getTypes(): string
    {
        $types = '';

        foreach ($this->data as $key => $value) {
            $types .= $this->getDataType($value);
        }

        return $types;
    }

    private function getDataType($data)
    {
        switch (gettype($data)) {
            case 'double':
                return 'd';
            case 'integer':
                return 'i';

            default:
                return 's';
        }
    }


}