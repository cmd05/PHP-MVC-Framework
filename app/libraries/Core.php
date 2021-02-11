<?php

/*
    * App Core Class
    * Creates URL & loads core controller
    * URL Format: /controller/method/params
*/ 

class Core {
    protected $currentController = "Pages";
    protected $currentMethod = "Index";
    protected $params = [];
    
    public function __construct() {
        $url = $this->getURL();

        // Look in controllers/ for first value
        if(!is_null($url)) {
            if(file_exists("../app/controllers/".ucwords($url[0]).".php")) {
                // Set as Controller
                $this->currentController = ucwords($url[0]);
                // Unset 0th index
                unset($url[0]);
            }
        }

        // Require Controller
        require_once '../app/controllers/'.$this->currentController.'.php';

        // Instantiate Controller
        $this->currentController = new $this->currentController;
        // Check for second part of URL
        if(isset($url[1])) {
            // If method exists in controller
            if(method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }
        // Get Params
        $this->params = $url ? array_values($url) : [];

        // Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL() {
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }
}