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
            $primaryColName = parent::GetPrimaryColumnName($table);
            $mappedRows = $this->MapRowsToEntity($tableRows, $primaryColName);

            $entityHashItem = new EntityHash($table, $mappedRows, $primaryColName);

            array_push(self::$_entityHash, $entityHashItem);
            
            $this->$table = $entityHashItem;
        }
    }
    private function ApplyVirtualDatabase() {
        foreach(self::$_entityHash as $entityHash) {
            if(!$entityHash->HasChanges())
                continue;
            
            foreach($entityHash->ToList() as $row) {
                switch($row->EntityState) {
                    case EntityState::MODIFIED:
                        parent::Update($entityHash->TableName(), $row, $entityHash->PrimaryColumn());
                        $row->EntityState = EntityState::UNMODIFIED;

                        break;

                    case EntityState::ADDED:
                        parent::Insert($entityHash->TableName(), $row, $entityHash->PrimaryColumn());
                        $row->EntityState = EntityState::UNMODIFIED;

                        break;

                    case EntityState::DELETED:
                        parent::Delete($entityHash->TableName(), $row, $entityHash->PrimaryColumn());

                        break;
                }
            }
        }
    }

    private function MapRowsToEntity(array $rows, $primaryColName) {
        $entities = array();

        foreach($rows as $row) {
            $entity = new Entity($row, EntityState::UNMODIFIED, $row["$primaryColName"]);

            array_push($entities, $entity);
        }

        return $entities;
    }
}

?>
