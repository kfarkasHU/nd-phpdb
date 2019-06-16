<?php

class DatabaseConfig {
    private static $_instance = null;
    private $_connection = null;

    private $_address;
    private $_username;
    private $_password;
    private $_database;

    public function __construct() {
        $this->_address = "localhost:3306";
        $this->_username = "root";
        $this->_password = "";
        $this->_database = "dbwrapper";
    }

    public static function GetInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new DatabaseConfig();
        }

        return self::$_instance;
    }

    public function DatabaseName() {
        return $this->_database;
    }

    public function Connect() {
        if(is_null($this->_connection)) {
            $this->_connection = mysqli_connect(
                $this->_address,
                $this->_username,
                $this->_password,
                $this->_database);
        }

        return $this->_connection;
    }

    public function Disconnect() {
        if(!is_null($this->_connection)) {
            mysqli_connect($this->_connection);
        }
    }
}

?>
