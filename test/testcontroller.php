<?php

require_once("testmanager.php");

class TestController {
    private $_manager;

    public function __construct() {
        $this->_manager = new TestManager();
    }

    public function WriteTestData() {

        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Add new element<br />";
        $this->_manager->AddNewElement();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Save changes<br />";
        $this->_manager->SaveChanges();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Update existing element<br />";
        $this->_manager->UpdateExistingElement();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Save changes<br />";
        $this->_manager->SaveChanges();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Delete existing element<br />";
        $this->_manager->DeleteExistingElement();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
        
        echo "Save changes<br />";
        $this->_manager->SaveChanges();
        echo "VDB: ";
        $this->_manager->WriteVirtualDatabase();
        echo "<br /><br />";
    }
}

?>
