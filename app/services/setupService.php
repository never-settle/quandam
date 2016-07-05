<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	Setup

	Sets up Quandam and generates the REST-API

	Author: Patrick Notar

*/

Class SetupService {

    private $db;

    // Entities is an array storing all simple entities
    private $entities;

    // Relations is an array storing all relational entities (1:n)
    private $relations;

    // Database settings are posted from you
    private $serverIp;
    private $username;
    private $password;
    private $databaseName;

    public function __construct() {
        $this->db = new Database();
        $this->setupDatabaseConnection();
        $this->assignTables();
        $this->generateEntities();
    }

    /**
     * Overrides Database-Config from config.php file for setup purposes
     **/
    public function setupDatabaseConnection() {
        $this->db = new Database($_POST);

//        $this->serverIp = $_POST['server-ip'];
//        $this->username = $_POST['username'];
//        $this->password = $_POST['password'];
//        $this->databaseName = $_POST['database-name'];

        $this->serverIp = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->databaseName = "quandam";
    }

    /**
     * Selects all tables from the database a user entered
     * @return array of kind $arr[$i]["TABLE_NAME"]
     **/
    private function getAllTablenames() {
        $this->db->query("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :databaseName");
        $this->db->bind("databaseName", $this->databaseName);
        return $this->db->resultset();
    }

    /**
     * Decide if an entity is a relational entity or a simple entity
     * and fill belonging array
     **/
    public function assignTables() {

        $allTables = $this->getAllTablenames();
        $this->entities = array();
        $this->relations = array();

        for ($i = 0; $i < sizeof($allTables); $i++) {
            $tableName = $allTables[$i]["TABLE_NAME"];
            if (strpos($tableName, '_has_') !== false) {
                $p = explode("_", $tableName);
                $this->relations[$p[0]] = $tableName;
                $this->relations[$p[2]] = $tableName;
            } else {
                array_push($this->entities, $tableName);
            }
        }

    }

    /**
     * Generates the API-Controller in /quandam/api/controller
     **/
    public function generateController() {
        //TODO Implement this beauty
    }

    /**
     * Selects all fields for a given table (eg. id, firstname,  lastname, ...)
     * @param String $entity Name of the DB-Table
     * @return array of kind $arr[$i]["COLUMN_NAME"]
     **/
    public function getFieldsFromEntity($entity) {
        $this->db->query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = :databaseName AND TABLE_NAME = :entity");
        $this->db->bind("databaseName", $this->databaseName);
        $this->db->bind("entity", $entity);
        return $this->db->resultset();
    }

    /**
     * Generates DAO-Classes for /api/entity
     **/
    public function generateEntities() {

        foreach ($this->entities as $entity) {

            $projectName = "quandam";

            // simple entity name
            $entityName = $entity;
            $entityNameUc = ucfirst($entity);
            $entityNamePlural = $this->pluralize($entityName);

            // relational entities
            $relationName = $this->getRelationName($entityName);
            $relationNamePlural = $this->pluralize($relationName);
            $relationTable = $this->relations[$entity];

            // get all fields for dao and make them private
            $fields = $this->getFieldsFromEntity($entityName);
            $field_str = "";
            for ($j = 0; $j < sizeof($fields); $j++) {
                $field_str .= "private $" . $fields[$j]["COLUMN_NAME"] . ";\n    ";
            }

            // get file contents (template)
            $fileContents = file_get_contents(API . "templates" . DS . "dao.template");

            // replace template placeholders with values
            $fileContents = str_replace("[PROJECT_NAME]", $projectName, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME]", $entityName, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_UC]", $entityNameUc, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_PLURAL]", $entityNamePlural, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_UC_PLURAL]", ucfirst($entityNamePlural), $fileContents);
            $fileContents = str_replace("[FIELDS]", $field_str, $fileContents);
            $fileContents = str_replace("[RELATION_NAME]", $relationName, $fileContents);
            $fileContents = str_replace("[RELATION_NAME_UC]", ucfirst($relationNamePlural), $fileContents);
            $fileContents = str_replace("[RELATION_NAME_PLURAL]", $relationNamePlural, $fileContents);
            $fileContents = str_replace("[RELATION_TABLE]", $relationTable, $fileContents);

            // write file
            file_put_contents(API . "entity" . DS . $entityName . "DAO.php", $fileContents);

        }


    }

    public static function pluralize($singular, $plural = null) {
        $last_letter = strtolower($singular[strlen($singular) - 1]);
        switch ($last_letter) {
            case 'y':
                return substr($singular, 0, -1) . 'ies';
            case 's':
                return $singular . 'es';
            default:
                return $singular . 's';
        }
    }

    private function getRelationName($entityName) {
        $p = explode("_", $this->relations[$entityName]);
        if (strcmp($p[2], $entityName)) {
            $relationName = $p[2];
        } else {
            $relationName = $p[0];
        }
    }

    static function factory() {
        return new SetupService();
    }

}

SetupService::factory();