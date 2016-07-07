<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", dirname($_SERVER['PHP_SELF']))[1] . "/app/config.php";

/*

	MemberRestController

	Interface between DAO and WebService, to react to errors or set status codes

	Author: Patrick Notar

*/

class MemberRestController extends BasicRestController {

    /**
     * Returns all members as JSON
     * @return string $response a JSON-String
     **/
    function getAllMembers() {

        $memberDao = new MemberDAO();
        $rawData = $memberDao->getAllMembers();

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No members found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;
    }

    /**
     * Returns Get values of a single member as JSON
     * @param int $id id of the member
     * @return string $response a JSON-String
     **/
    public function getMember($id) {

        $memberDao = new MemberDAO($id);
        $rawData = $memberDao->getMember();

        if (empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => 'No members found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;

    }

    /**
     * Returns specific field from the member entity
     * @param int $id id of the member
     * @param string $field field of the member entity
     * @return string $response a JSON-String
     **/
    public function get($field, $id) {

        $memberDao = new MemberDAO($id);
        $rawData = $memberDao->get($field);

        if (empty($rawData[$field])) {
            $statusCode = 404;
            $rawData = array('error' => 'No members found!');
        } else {
            $statusCode = 200;
        }

        $this->setHttpHeaders($statusCode);
        $response = $this->encodeJson($rawData);
        echo $response;
    }
}