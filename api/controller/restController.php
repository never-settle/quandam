<?php

/*

	RestController

	Interface for all Controllers. A Controller serves data from DAO to View in a Context

	Author: Patrick Notar

*/

interface RestController {

    /**
     * Returns all Users as JSON
     * @return string $response a JSON-String
     **/
    function getAllUsers();

    /**
     * Returns Get values of a single user as JSON
     * @param int $id id of the user
     * @return string $response a JSON-String
     **/
    public function getUser($id);

    /**
     * Returns specific field from the user entity
     * @param int $id id of the user
     * @param string $field field of the user entity
     * @return string $response a JSON-String
     **/
    public function get($field, $id);

}