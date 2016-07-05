<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	A script that routes requests to controller

	Routing

	Author: Patrick Notar

*/

$request = $_GET["request"] ?? "";
$field = $_GET["field"] ?? "";

if (strcmp($_SERVER["REQUEST_METHOD"], "GET") === 0) {

    switch ($request) {

        case "all-user": {
            $handler = new UserRestController();
            $handler->getAllUsers();
            break;
        }

        case "user": {

            $handler = new UserRestController();
            if (!$field) {
                $handler->getUser($_GET["id"]);
                break;
            }

            $handler->get($field, $_GET["id"]);
            break;
        }

        case "" : {
            //404 - not found;
            break;
        }
    }

}