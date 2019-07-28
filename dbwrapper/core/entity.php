<?php

class Entity {
    public function __construct($data, $entityState, $uniqeValue) {
        $this->Data = $data;
        $this->DataUniqueValue = $uniqeValue;
        $this->EntityState = $entityState;
    }

    public $Data;
    public $DataUniqueValue;
    public $EntityState;
}

?>