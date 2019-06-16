<?php

require_once("entity.php");
require_once("findhelper.php");

class EntityHash {

    public function __construct($tableName, $rows) {
        $this->_tableName = $tableName;
        $this->_rows = $rows;
        $this->_hasChanges = false;
    }

    private $_tableName;
    private $_rows;
    private $_hasChanges;

    public function TableName() {
        return $this->_tableName;
    }

    public function HasChanges() {
        return $this->_hasChanges;
    }

    public function Add($object) {
        $entity = $this->CreateNewEntity($object);

        array_push($this->_rows, $entity);

        $this->_hasChanges = true;
    }
    public function AddRange($objects) {
        foreach($entities as $entity) {
            $this->Add($entity);
        }
    }
    public function Update($entity) {
        if($this->IsObjectEntity($entity)) {
            $entity->EntityState = EntityState::MODIFIED;
        }

        $this->_hasChanges = true;
    }
    public function UpdateRange($entities) {
        foreach($entities as $entity) {
            $this->Update($entity);
        }
    }
    public function Delete($entity) {
        if($this->IsObjectEntity($entity)) {
            $entity->EntityState = EntityState::DELETED;
        }

        $this->_hasChanges = true;
    }
    public function DeleteRange($entities) {
        foreach($entities as $entity) {
            $this->Delete($entity);
        }
    }
    public function ToList() {
        return $this->_rows;
    }
    public function Find($expression) {
        return FindHelper::ApplyFilter($this->_rows, $expression);
    }

    private function IsObjectEntity($object) {
        return $object instanceof Entity;
    }
    private function CreateNewEntity($object) {
        $entity = new Entity($object, EntityState::ADDED);

        return $entity;
    }
}

?>
