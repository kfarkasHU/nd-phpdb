<?php

class SelectExpression {
    public function __construct() {
        $this->ColValues = array();
    }

    public $ColValues;
    public $OrderByColName;
    public $OrderByType;
    public $Limit;
}

class OrderByType {
    const ASC = 1;
    const DESC = 2;
}

class ColumnValuePair {
    public function __construct($colName, $colValue, $operator) {
        $this->ColName = $colName;
        $this->ColValue = $colValue;
        $this->Operator = $operator;
    }

    public $ColName;
    public $ColValue;
    public $Operator;
}

class Operator {
    const EQUALS = 1;
    const BIGGER = 2;
    const SMALLER = 3;
    const CONTAINS = 4;
    const BIGGEROREQUALS = 5;
    const SMALLEROREQUALS = 6;
    const STARTSWTIH = 7;
    const ENDSWITH = 8;
}

?>
