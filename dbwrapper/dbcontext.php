<?php

require_once("core/dbkernel.php");
require_once("core/entityhash.php");
require_once("core/entity.php");
require_once("core/entitystate.php");

class DatabaseContext extends DatabaseKernel {
    private static $_entityHash = array();

    public function __construct() {
        parent::__construct();

        $this->CreateVirtualDatabase();
    }

    public function SaveChanges() {
        $this->ApplyVirtualDatabase();
        $this->CreateVirtualDatabase();
    }

    public function Rollback() {
        $this->CreateVirtualDatabase();
    }

    private function CreateVirtualDatabase() {
        $tables = parent::GetTables();

        foreach($tables as $table) {
            $tableRows = parent::GetTableRows($table);
            $mappedRows = $this->MapRowsToEntity($tableRows);

            $entityHashItem = new EntityHash($table, $mappedRows);

            array_push(self::$_entityHash, $entityHashItem);
            
            $this->$table = $entityHashItem;
        }
    }
    private function ApplyVirtualDatabase() {
        // emiatt kell majd a rowid a mysql felől!

        foreach(self::$_entityHash as $entityHash) {
            if(!$entityHash->HasChanges())
                continue;
            
            foreach($entityHash->ToList() as $row) {
                switch($row->EntityState) {
                    case EntityState::MODIFIED:
                        parent::Update($entityHash->TableName(), $row);
                        break;

                    case EntityState::ADDED:
                        parent::Insert($entityHash->TableName(), $row);
                        break;

                    case EntityState::DELETED:
                        parent::Delete($entityHash->TableName(), $row);
                        break;
                }
            }
        }
    }

    private function MapRowsToEntity(array $rows) {
        $entities = array();

        foreach($rows as $row) {
            $entity = new Entity($row, EntityState::UNMODIFIED);

            array_push($entities, $entity);
        }

        return $entities;
    }
}

?>
