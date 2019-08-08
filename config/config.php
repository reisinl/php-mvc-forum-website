<?php

// Database configuration
$config['db']['host'] = 'localhost:3306';
$config['db']['username'] = 'root';
$config['db']['password'] = '';
$config['db']['dbname'] = 'forum_language';

$config['session']['expire'] = 600;

// Default controller and operation name
$config['defaultController'] = 'Login';
$config['defaultAction'] = 'index';

return $config;
