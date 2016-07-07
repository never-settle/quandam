<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", dirname($_SERVER['PHP_SELF']))[1] . "/app/config.php";

/*
	Quandam API

	This class provides a RESTful API interface for Quandam

	Output: A formatted HTTP response

	Author: Patrick Notar
*/

class BasicRestController {

    private $httpVersion = "HTTP/1.1";

    /**
     * Sets the response code and http header to json
     * @param int $statusCode The current HTTP status code
     * @return array httpStatus The http status message
     **/
    public function setHttpHeaders($statusCode) {
        $statusMessage = $this->getHttpStatusMessage($statusCode);
        header($this->httpVersion . " " . $statusCode . " " . $statusMessage);
        header("Content-Type: application/json");
    }

    /**
     * Get the current status message
     * @param int $statusCode The current HTTP status code
     * @return array httpStatus The http status message
     **/
    public function getHttpStatusMessage($statusCode) {
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    /**
     * Encodes the result as JSON
     * @param array $responseData contains the response from RestController-Classes
     * @throws Exception
     * @return string a JSON-String
     **/
    public function encodeJson($responseData) {
        if (!is_array($responseData)) throw new Exception("response data must be an array.");
        if (is_null($responseData)) throw new Exception("response data must not be null");
        $jsonResponse = json_encode($responseData);
        Logger::info("deserializing response to json string: " . $jsonResponse);
        return $jsonResponse;
    }

}
