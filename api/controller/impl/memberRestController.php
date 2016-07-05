<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	UserRestController

	Interface between DAO and WebService, to react to errors or set status codes

	Author: Patrick Notar

*/

class MemberRestController extends BasicRestController {

    /**
     * Returns all Users as JSON
     * @return string $response a JSON-String
     **/
    function getAllMembers() {

        $memberDao = new MemberDAO();
        $rawData = $memberDao->getAllMembers();

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No users found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;
    }

    /**
     * Returns Get values of a single user as JSON
     * @param int $id id of the user
     * @return string $response a JSON-String
     **/
    public function getMember($id) {

        $memberDao = new MemberDAO($id);
        $rawData = $memberDao->getMember();

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No user found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;

    }

    /**
     * Returns specific field from the user entity
     * @param int $id id of the user
     * @param string $field field of the user entity
     * @return string $response a JSON-String
     **/
    public function get($field, $id) {

        $memberDao = new memberDAO($id);
        $rawData = $memberDao->get($field);

        if (empty($rawData[$field])) {
            $statusCode = 404;
            $rawData = array('error' => 'No user found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;
    }
}