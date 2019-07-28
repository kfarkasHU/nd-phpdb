<?php

require_once('dbhelper.php');

class DatabaseKernel {

    protected $_dbHelper;

    public function __construct() {
        $this->_dbHelper = new DbHelper();
    }

    protected function GetTables() {
        return $this->_dbHelper->GetTables();
    }

    protected function GetTableRows($tableName) {
        $command = "SELECT * FROM $tableName";

        return $this->_dbHelper->DoQueryAssoc($command);
    }

    protected function GetPrimaryColumnName($tableName) {
        return $this->_dbHelper->GetTablePrimaryKey($tableName);
    }

    protected function Insert($tableName, $row, $uniqueColName) {
        $colsToInsert = "";
        $valsToInsert = "";

        $rowArray = (array)$row->Data;

        $keys = array_keys($rowArray);
        foreach($keys as $property) {
            if($property == $uniqueColName)
                continue;

            if($colsToInsert !== "")
                $colsToInsert .= ", ";

            if($valsToInsert !== "")
                $valsToInsert .= ", ";

            $colsToInsert .= "$property";
            $valsToInsert .= "'$rowArray[$property]'";
        }

        $command = "";
        $command .= "INSERT INTO $tableName (";      
        $command .= $colsToInsert;
        $command .= ") VALUES (";
        $command .= $valsToInsert;
        $command .= ")";

        $this->_dbHelper->DoQuery($command);
    }

    protected function Update($tableName, $row, $uniqueColName) {
        $colValToUpdate = "";

        $rowArray = (array)$row->Data;

        $keys = array_keys($rowArray);
        foreach($keys as $property) {
            if($property == $uniqueColName)
                continue;

            if($colValToUpdate !== "")
                $colValToUpdate .= ", ";

            $colValToUpdate .= "$property=";

            if(!is_null($rowArray[$property])) {
                $colValToUpdate .= "'$rowArray[$property]'";
            }
            else {
                $colValToUpdate .= NULL;
            }
        }

        $command = "";
        $command .= "UPDATE $tableName SET ";      
        $command .= $colValToUpdate;
        $command .= " ";
        $command .= "WHERE $uniqueColName=";
        $command .= $rowArray[$uniqueColName];

        $this->_dbHelper->DoQuery($command);
    }

    protected function Delete($tableName, $row, $uniqueColName) {
        $rowArray = (array)$row->Data;

        $command = "";
        $command .= "DELETE FROM $tableName ";
        $command .= "WHERE $uniqueColName=";
        $command .= $rowArray[$uniqueColName];

        $this->_dbHelper->DoQuery($command);
    }
}

?>
