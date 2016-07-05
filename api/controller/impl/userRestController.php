<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

class UserRestController extends BasicRestController implements RestController {

    function getAllUsers() {

        $userDao = new UserDAO();
        $rawData = $userDao->getAllUser();

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


    public function getUser($id) {

        $userDao = new UserDAO($id);
        $rawData = $userDao->getUser();

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


    public function get($field, $id) {

        $userDao = new UserDAO($id);
        $rawData = $userDao->get($field);

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