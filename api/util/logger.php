<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

/*

	Logger

	This class provides logging methods

	Author: Patrick Notar

*/

class Logger {

    const ERROR   = "ERROR";
    const WARNING = "WARNING";
    const NOTICE  = "NOTICE";
    const INFO    = "INFO";
    const DEBUG   = "DEBUG";

    public static function critical($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::CRITICAL, $message, $backtrace, $exception = null);
    }

    public static function error($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::ERROR, $message, $backtrace, $exception);
    }

    public static function warning($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::WARNING, $message, $backtrace, $exception);
    }

    public static function notice($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::NOTICE, $message, $backtrace, $exception);
    }

    public static function info($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::INFO, $message, $backtrace, $exception);
    }

    public static function debug($message = null, $backtrace = null, $exception = null) {
        self::print_to_file(self::DEBUG, $message, $backtrace, $exception);
    }

    private static function print_to_file($state, $message = null, $backtrace = null, $exception = null) {

        $details = "";

        if (is_array($message)) {
            $message = implode(", ", $message);
        }

        if ($backtrace) {
            $p = explode("/", $backtrace[0]["file"]);
            $p = explode(DS, $p[0]);
            $file      = $p[sizeof($p) - 1];
            $function  = $backtrace[0]["function"];
            $line      = $backtrace[0]["line"];
            $details   = " [${file}, ${function}(), Line ${line}]: \n";
        }

        if ($exception) {
            $lines  = implode(" ", explode(" ", wordwrap($exception, 128, "\n\t\t\t\t\t\t\t  # ")));
            $output = "[" . date("d.m.Y H:i:s") . "] [" . $state . "] " . $details . $message . "\n\t\t\t\t\t\t\t  # ";
        } else {
            $output = "[" . date("d.m.Y H:i:s") . "] [" . $state . "] " . $details . $message;
        }

        file_put_contents(LOG_OUT, $output . "\n", FILE_APPEND);

    }



}
