<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", dirname($_SERVER['PHP_SELF']))[1] . "/app/config.php";

/*

	A script that routes requests to controller

	Routing

	Author: Patrick Notar

*/

$request = $_GET["request"] ?? "";
$field = $_GET["field"] ?? "";

if (strcmp($_SERVER["REQUEST_METHOD"], "GET") === 0) {

    switch ($request) {


        // Address
        // ----------------------------------------------------------------------------------------
        case "all-addresses": {
            $handler = new AddressRestController();
            $handler->getAllAddresses();
            break;
        }

        case "address": {
            $handler = new AddressRestController();
            if (!$field) {
                $handler->getAddress($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Box
        // ----------------------------------------------------------------------------------------
        case "all-boxes": {
            $handler = new BoxRestController();
            $handler->getAllBoxes();
            break;
        }

        case "box": {
            $handler = new BoxRestController();
            if (!$field) {
                $handler->getBox($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Country
        // ----------------------------------------------------------------------------------------
        case "all-countries": {
            $handler = new CountryRestController();
            $handler->getAllCountries();
            break;
        }

        case "country": {
            $handler = new CountryRestController();
            if (!$field) {
                $handler->getCountry($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Member
        // ----------------------------------------------------------------------------------------
        case "all-members": {
            $handler = new MemberRestController();
            $handler->getAllMembers();
            break;
        }

        case "member": {
            $handler = new MemberRestController();
            if (!$field) {
                $handler->getMember($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Party
        // ----------------------------------------------------------------------------------------
        case "all-parties": {
            $handler = new PartyRestController();
            $handler->getAllParties();
            break;
        }

        case "party": {
            $handler = new PartyRestController();
            if (!$field) {
                $handler->getParty($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        // Thief
        // ----------------------------------------------------------------------------------------
        case "all-thieves": {
            $handler = new ThiefRestController();
            $handler->getAllThieves();
            break;
        }

        case "thief": {
            $handler = new ThiefRestController();
            if (!$field) {
                $handler->getThief($_GET["id"]);
                break;
            }
            $handler->get($field, $_GET["id"]);
            break;
        }
        // ----------------------------------------------------------------------------------------



        case "" : {
            //404 - not found;
            break;
        }
    }
}