<?php
# Load Config
require_once 'config/config.php';

# Load libraries

# Autoload libraries

spl_autoload_register(function($className) {
    $path = "libraries/$className.php";
    require_once $path;
});

// require_once 'libraries/Core.php';
// require_once 'libraries/Database.php';
// require_once 'libraries/Controller.php';