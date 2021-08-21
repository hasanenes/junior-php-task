<?php

class DatabaseHandler
{
    protected $dbUsername = 'root';
    protected $dbPassword = '';
    public $conn;
    protected $dsn = "mysql:host=localhost;dbname=products;charset=utf8mb4";
    protected $options = [
        PDO::ATTR_EMULATE_PREPARES => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->dbUsername, $this->dbPassword, $this->options);
        } catch (Exception $e) {
            error_log($e->getMessage());
            exit('Error connecting to database');
        }
    }
}

