<?php

/*

	UserRestControllerTest

	Test REST-Calls for User

	Author: Patrick Notar

    Routes:
        rest/1.0/user
            Returns all users

        rest/1.0/user/[0-9]
            Returns id specific user information

        rest/1.0/user/[0-9]/field
            Returns the requested field

        rest/1.0/user/[0-9]/superpower
            Returns all superpowers of a user

*/

class UserRestControllerTest extends PHPUnit_Framework_TestCase {

    function test_get_all_users() {

        $url = "http://localhost/quandam/rest/1.0/user";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $result = json_decode($response);

        // test size
        $this->assertGreaterThan(0, sizeof($result));

        // test contents
        $this->assertEquals($result[0]->firstname, "Peter");
        $this->assertEquals($result[0]->id, "1");
        $this->assertEquals($result[1]->firstname, "Clark");
        $this->assertEquals($result[1]->id, "2");
        $this->assertEquals($result[2]->firstname, "Bruce");
        $this->assertEquals($result[2]->id, "3");

        curl_close($curl);
    }

    function test_get_user_data_by_id() {
        $range = [1, 2, 3];
        foreach ($range as $r) {
            $url = "http://localhost/quandam/rest/1.0/user/$r";
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $result = json_decode($response);

            // test size
            $this->assertGreaterThan(0, sizeof($result));

            curl_close($curl);
        }
    }

    function test_get_field_from_user_with_id() {
        $range = [1, 2, 3];
        $fields = ["firstname", "id"];

        foreach ($range as $r) {

            foreach ($fields as $f) {
                $url = "http://localhost/quandam/rest/1.0/user/$r/$f";
                $curl = curl_init($url);

                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                $result = json_decode($response);

                // test size
                $this->assertGreaterThan(0, sizeof($result));

                curl_close($curl);
            }
        }
    }

    function test_get_superpowers_from_user_with_id() {

        $range = [1, 2, 3];
        foreach ($range as $r) {
            $url = "http://localhost/quandam/rest/1.0/user/$r/superpower";
            $curl = curl_init($url);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            $result = json_decode($response);

            // test size
            $this->assertGreaterThan(0, sizeof($result));

            curl_close($curl);
        }
    }

    function test_no_results_found_with_invalid_id() {

        $url = "http://localhost/quandam/rest/1.0/user/42";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $result = json_decode($response);

        // test size
        $this->assertGreaterThan(0, sizeof($result));
        $this->assertEquals("No user found!", $result->error);

        curl_close($curl);
    }


}
