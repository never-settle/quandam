<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	Database

	Controls Database interaction with simple database methods

	Author: Patrick Notar

*/

class Database {

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;

    public function __construct($connectionParams = "") {

        if ($connectionParams) {
            $this->host = $connectionParams["server-ip"];
            $this->user = $connectionParams["username"];
            $this->pass = $connectionParams["password"];
            $this->dbname = $connectionParams["database-name"];
        }

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        } else {
            $dsn = 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;host=' . $this->host . ';dbname=' . $this->dbname;
        }

        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (Exception $e) {
            $this->mapExceptionasJson();
            die;
        }

    }

    private function mapExceptionasJson() {
        $statusCode = 500;
        $rawData = array('error' => 'Connection to Database timed out');

        $basicRestController = new BasicRestController();

        $basicRestController->setHttpHeaders($statusCode);
        $response = $basicRestController->encodeJson($rawData);
        echo $response;

    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function compile($params, $instance) {

        $query = "INSERT INTO $instance([ATTR]) VALUES([VALUES]);";
        $attributes = "";
        $values = "";

        foreach ($params as $attr => $value) {

            $attributes .= $attr . ", ";
            $values .= ":" . $attr . ", ";

        }

        $attributes = substr($attributes, 0, -2);
        $values = substr($values, 0, -2);

        $query = preg_replace('/\[ATTR\]/', $attributes, $query);
        $query = preg_replace('/\[VALUES\]/', $values, $query);

        $this->stmt = $this->dbh->prepare($query);

    }

    public function bind($param, $value, $type = null) {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function bind_all($params) {
        foreach ($params as $attr => $value) {
            $this->bind($attr, $value);
        }
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function resultset() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single() {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function row_count() {
        return $this->stmt->rowCount();
    }

    public function last() {
        return $this->dbh->lastInsertId();
    }
}