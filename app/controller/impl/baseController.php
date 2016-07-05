<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/quandam/app/config.php";

Class BaseController {

    public $twig;
    private $loader;
    private $options;

    public $context;
    private $view;

    public function __construct($target_dir = "") {
        $this->view = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

        $this->loader = new Twig_Loader_Filesystem(BASE . '/app/view/' . $target_dir);
        $this->loader->addPath(BASE . '/app/view/');
        $this->options = array(
            'debug' => true,
            'cache' => false,
            'auto_reload' => true
        );
        $this->twig = new Twig_Environment($this->loader, $this->options);

        $this->setBasicContext();
        $this->setResourcePath(RESOURCES);
    }

    public function setResourcePath($path) {
        $this->context["globals"]["resources"] = $path;
    }

    public function setBasicContext() {
//        $userDao = new UserDAO(1);
//        $firstname = $userDao->get("firstname");
//        $this->context["globals"] = array(
//            $this->keyOf($firstname) => $this->valueOf($firstname)
//        );
    }

    public function render($context) {
        $this->template = $this->twig->loadTemplate($this->view . '.twig');
        echo $this->template->render($context);
    }

    public function getView() {
        return $this->view;
    }

    public function getLoader() {
        return $this->loader;
    }

    public function getOptions() {
        return $this->options;
    }

    public function valueOf($arr) {
        return $arr[$this->keyOf($arr)];
    }

    public function keyOf($arr) {
        if (!is_array($arr)) throw new Exception("arr data must be an array.");
        if (is_null($arr)) throw new Exception("arr data must not be null");
        if (sizeof($arr) != 1) throw new Exception("arr must contain a single key-value pair");
        return array_keys($arr)[0];
    }

}