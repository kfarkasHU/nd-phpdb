<?php

require_once("/../dbconfig.php");

class DatabaseKernel {
    private $_cfg;
    private $_connection;

    public function __construct() {
        $this->_cfg = DatabaseConfig::GetInstance();

        $this->_connection = $this->_cfg->Connect();
    }

    protected function GetTables() {
        $dbName = $this->_cfg->DatabaseName();
        
        $command = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA LIKE '$dbName'";
        
        $tables = $this->DoQueryAssoc($command);
        $tableNames = array();

        foreach($tables as $table) {
            array_push($tableNames, $table["TABLE_NAME"]);
        }

        return $tableNames;
    }

    protected function GetTableRows($tableName) {
        $command = "SELECT * FROM $tableName";

        return $this->DoQueryAssoc($command);
    }

    protected function Insert($tableName, $row) {

    }

    protected function Update($tableName, $row) {

    }

    protected function Delete($tableName, $row) {

    }

    private function DoQuery($command) {
        $query = mysqli_query($this->_connection, $command);

        return $query;
    }

    private function DoQueryAssoc($command) {
        $query = $this->DoQuery($command);      

        $returnValue = array();

        while ($row = mysqli_fetch_assoc($query)) {
            array_push($returnValue, $row);
        }

        return $returnValue;
    }
}

?>
