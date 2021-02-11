<?php

    /* PDO DATABASE CLASS
    * Connect to Database
    * Prepared Statement
    * Bind Values
    * Return Values
    */

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct() {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $opts = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $opts);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            die($this->error);
        }
    }
    
    // Querying with prepared stmts
    public function query($sql) {
        $this->stmt = $this->dbh->prepare($sql);

    }

    public function bind($params, $value, $type = null) {
        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT; 
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL; 
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL; 
                    break;
                default:
                    $type = PDO::PARAM_STR; 
            }
        }

        $this->stmt->bindValue($params, $value, $type);
    }

    // Execute prepared statement
    public function execute() {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    // Get single record as object
    public function fetchRow() {
        $this->execute();
        return $this->stmt->fetch();
    }

    // Get Row Count
    public function rowCount() {
        return $this->stmt->rowCount();
    }
}