<?php
class DB {
    public $host;
    public $username;
    public $password;
    public $name;

    /**
     * DB constructor.
     *
     * @param $host
     * @param $username
     * @param $password
     * @param $name
     */
    public function __construct($host, $username, $password, $name)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;

        // connect to DB
        $this->link = $this->connect();

        // select DB
        $this->select();
    }

    /**
     * Connect to DB
     *
     * @return mysqli|resource
     */
    function connect()
    {
        if (function_exists('mysql_connect')) {
            $res = mysql_connect($this->host, $this->username, $this->password);
        }
        else {
            $res = mysqli_connect($this->host, $this->username, $this->password);
        }

        return $res;
    }

    /**
     * Select DB
     *
     * @return bool
     */
    function select()
    {
        if (function_exists('mysql_select_db')) {
            $select = mysql_select_db($this->name, $this->link);
        }
        else {
            $select = mysqli_select_db($this->link, $this->name);
        }

        return $select;
    }

    /**
     * Execute query
     *
     * @param $query
     * @return bool|mysqli_result|resource
     */
    function query($query)
    {
        if (function_exists('mysql_query')) {
            $result = mysql_query($query, $this->link);
        }
        else {
            $result = mysqli_query($this->link, $query);
        }

        return $result;
    }

    /**
     * Fetch result as an associative array
     *
     * @param $query
     * @return array|null
     */
    public function assoc($query)
    {
        $result = $this->query($query);

        if (function_exists('mysql_fetch_assoc')) {
            $row = mysql_fetch_assoc($result);
        }
        else {
            $row = mysqli_fetch_assoc($result);
        }

        return $row;
    }
}