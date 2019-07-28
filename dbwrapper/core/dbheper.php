<?php

require_once("/../dbconfig.php");

class DbHelper {
    private $_cfg;
    private $_connection;

    public function __construct() {
        $this->_cfg = DatabaseConfig::GetInstance();

        $this->_connection = $this->_cfg->Connect();
    }

    public function GetTables() {
        $dbName = $this->_cfg->DatabaseName();
            
        $command = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '$dbName'";
        
        $tables = $this->DoQueryAssoc($command);
        $tableNames = array();

        foreach($tables as $table) {
            array_push($tableNames, $table["TABLE_NAME"]);
        }

        return $tableNames;
    }

    public function GetTablePrimaryKey($tableName) {
        $command = "SELECT * FROM information_schema.COLUMNS WHERE TABLE_NAME = '$tableName' AND COLUMN_KEY = 'PRI'";

        $primaryKey = $this->DoQueryAssoc($command);

        if(count($primaryKey) == 0)
            die("Table must contain a Primary Key!");

        return $primaryKey[0]["COLUMN_NAME"];
    }

    public function DoQuery($command) {
        $query = mysqli_query($this->_connection, $command);

        return $query;
    }

    public function DoQueryAssoc($command) {
        $query = $this->DoQuery($command);      

        $returnValue = array();

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($returnValue, $row);
        }

        return $returnValue;
    }

}

?>
