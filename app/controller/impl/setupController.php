<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/" . explode("/", dirname($_SERVER['PHP_SELF']))[1] . "/app/config.php";

/*

	SetupController

	Renders the Template to setup Quandam

	Author: Patrick Notar

*/
Class SetupController extends BaseController implements viewController {

    public function __construct() {
        parent::__construct();
        $this->setContext();
        $this->render($this->context);
    }

    public function setContext() {
    }

    static function factory() {
        return new SetupController;
    }

}

SetupController::factory();