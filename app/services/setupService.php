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
                $this->relations[$p[0]] = $p[2];
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
            $relationStr = "";

            // simple entity name
            $entityName = $entity;
            $entityNameUc = ucfirst($entity);
            $entityNamePlural = $this->pluralize($entityName);

            // relational entities
            // # bad code
            foreach ($this->relations as $e => $relation) {

                // lookup relations (does this dao need relational selects?
                if (strcmp($e, $entity) == 0 || strcmp($relation, $entity) == 0) {

                    // setup environment
                    // how to decide between address_has_user and user_has_address?
                    $relationTable = $entity . "_has_" . $relation;
                    if (strcmp($relation, $entity) == 0) {
                        $relationTable = $e . "_has_" . $relation;
                        $relation = $e;
                    }

                    $relationNamePlural = $this->pluralize($relation);
                    $relationNamePluralUc = ucfirst($this->pluralize($relation));

                    // get file contents (dao-relations.template)
                    $relationStr .= file_get_contents(API . "templates" . DS . "dao-relations.template");
                    $relationStr = str_replace("[RELATION_NAME]", $relation, $relationStr);
                    $relationStr = str_replace("[RELATION_NAME_UC]", $relationNamePluralUc, $relationStr);
                    $relationStr = str_replace("[RELATION_NAME_PLURAL]", $relationNamePlural, $relationStr);
                    $relationStr = str_replace("[RELATION_TABLE]", $relationTable, $relationStr);
                }
            }

            // get all fields for dao and make them private
            $fields = $this->getFieldsFromEntity($entityName);
            $fieldStr = "";
            for ($j = 0; $j < sizeof($fields); $j++) {
                $fieldStr .= "private $" . $fields[$j]["COLUMN_NAME"] . ";\n    ";
            }

            // get file contents (template)
            $fileContents = file_get_contents(API . "templates" . DS . "dao.template");

            // replace template placeholders with values
            $fileContents = str_replace("[RELATIONS]", $relationStr, $fileContents);
            $fileContents = str_replace("[PROJECT_NAME]", $projectName, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME]", $entityName, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_UC]", $entityNameUc, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_PLURAL]", $entityNamePlural, $fileContents);
            $fileContents = str_replace("[ENTITY_NAME_UC_PLURAL]", ucfirst($entityNamePlural), $fileContents);
            $fileContents = str_replace("[FIELDS]", $fieldStr, $fileContents);


            // write file
            file_put_contents(API . "entity" . DS . $entityName . "DAO.php", $fileContents);

        }


    }

    /**
     * Returns the Plural of a word
     * @param String $singular (e.g. address)
     * @return String $plural (e.g. addresses)
     **/
    public static function pluralize($singular) {

        $length = strlen($singular);
        $lastChar = strtolower($singular[$length - 1]);

        $endings = array(
            "y" => array($length - 1, 'ies'),
            "f" => array($length - 1, 'ves'),
            "s" => array($length, 'es'),
            "o" => array($length, 'es'),
            "x" => array($length, 'es'),
        );

        if (isset($endings[$lastChar])) {
            $replaceWith = $endings[$lastChar];
        } else {
            $replaceWith = array(strlen($singular), 's');
        }

        return substr($singular, 0, $replaceWith[0]) . $replaceWith[1];

    }

    private function getRelationName($entityName) {
        if (isset($this->relations[$entityName])) {
            return $this->relations[$entityName];
        }
    }

    static function factory() {
        return new SetupService();
    }

}

SetupService::factory();