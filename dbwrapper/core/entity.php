<?php

class Entity {
    public function __construct($data, $entityState) {
        $this->Data = $data;
        $this->EntityState = $entityState;
    }

    public $Data;
    public $EntityState;
}

?>