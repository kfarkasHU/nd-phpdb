<?php

require_once("/../dbwrapper/dbcontext.php");
require_once("/../dbwrapper/selectexpression.php");

class TestManager {

    private $_context;

    public function __construct() {
        $this->_context = new DatabaseContext();
    }

    public function WriteVirtualDatabase(){
        echo json_encode($this->_context->entitya->ToList());
    }

    public function AddNewElement() {
        $array = array();
        $array["Id"] = 5;
        $array["Label"] = "Teszt label";

        $object = (object)$array;
        $this->_context->entitya->Add($object);
    }

    public function UpdateExistingElement() {
        $entity = $this->_context->entitya->Find($this->CreateSelectById(2));
        $entity->Data["Label"] = "TESZT";

        $this->_context->entitya->Update($entity);
    }

    public function DeleteExistingElement() {
        $entity = $this->_context->entitya->Find($this->CreateSelectById(2));

        $this->_context->entitya->Delete($entity);
    }

    public function SaveChanges() {
        $this->_context->SaveChanges();
    }

    private function CreateSelectById($id) {
        $expression = new SelectExpression();
        $expression->Limit = 1;
        
        $colVal = new ColumnValuePair("Id", 2, Operator::EQUALS);
        array_push($expression->ColValues, $colVal);

        return $expression;
    }
}

?>
