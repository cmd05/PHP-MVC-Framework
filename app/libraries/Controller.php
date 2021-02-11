<?php

    /* 
    * Base Controller
    * Loads Models and Views
    */

    class Controller {
        // Load Model
        public function model($model) {
            // Require Model 
            require_once '../app/models/'.$model.'.php';

            // Instantiate Model
            return new $model;
        }

        // Load View
        public function view($view, $data = []) {
            // Check View
            (file_exists('../app/views/'.$view.'.php')) ? require_once '../app/views/'.$view.'.php' : die('Not Found'); 
        }
    }