<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	UserDAO (Data Access Object)

	This class represents the User-Entity and contains all Getter and Setter-Methods.

	Author: Patrick Notar

*/

Class UserDAO {

    protected $db;

    // all users
    private $users;

    // declare fields here
    private $id;
    private $firstname;

    // relational data
    private $relationalData;

    /**
     * Default constructor, initialize without ID for accessing public methods
     **/
    public function __construct($id = 0) {
        $this->db = new Database();
        if ($id != 0) {
            $this->id = $id;
            $this->init();
        }
    }

    /**
     * Initalizes the user object with all relational datasets
     **/
    private function init() {

        $this->users = $this->getAllUser();
        $this->relationalData = $this->getRelationalData();

        $user = $this->getUser();
        if ($user) {
            foreach ($user as $k => $v) {
                $this->{$k} = $v;
            }
        }
    }

    /**
     * Returns an array of all users
     * @return array $this->users all users
     **/
    public function getAllUser() {
        $this->db->query("SELECT * FROM user");
        $this->users = $this->db->resultset();
        return $this->users;
    }

    /**
     * Returns a key-value pair (as array) of a single user
     * @return array $this->user[$this->id - 1] a single user
     **/
    public function getUser() {
        if (isset($this->users[$this->id - 1])) {
            return $this->users[$this->id - 1];
        }
    }

    /**
     * Returns a key-value pair (as array) of a requested field by invoking member variables
     * @param string $field the requested field
     * @return array $field => $this->{$field} key-value pair of a single user
     **/
    public function get($field) {
        return array($field => $this->{$field});
    }

    /**
     * Returns a set of relational data that are related to current user (by checking $this->id)
     * @return array $field => all users related to current user
     **/
    private function getRelationalData() {
        $this->db->query("SELECT * FROM user, user_has_relation, relation WHERE user.id = user_has_relation.user_id AND user_has_relation.relation_id = relation.id AND user.id = :id");
        $this->db->bind("id", $this->id);
        $this->relationalData = $this->db->resultset();
        return $this->relationalData;
    }
}