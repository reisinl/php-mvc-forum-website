<?php
// Set application directory to the current directory
define('APP_PATH', __DIR__ . '/');

// Turn on debug mode
define('APP_DEBUG', true);

// Loading frame file
require(APP_PATH . 'core/Core.php');

// Load configuration file
$config = require(APP_PATH . 'config/config.php');

// Instantiated framework class
(new core\Core($config))->run();
