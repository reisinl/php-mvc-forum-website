<?php

namespace core;

// Framework root directory
defined('CORE_PATH') or define('CORE_PATH', __DIR__);

/**
 * core part of framework
 */
class Core
{
    // Configuration content
    protected $config = [];
    protected $action;
    protected $controller;
    protected $parameter;

    public function __construct($config)
    {
        $this->config = $config;
        $this->controller = $this->config['defaultController'];
        $this->action = $this->config['defaultAction'];
        $this->parameter = array();
    }

    // run the application
    public function run()
    {
        spl_autoload_register(array($this, 'loadClass'));
        $this->setReporting();
        $this->removeMagicQuotes();
        $this->unregisterGlobals();
        $this->setDbConfig();
        $this->startSession();
        $this->loadLanguage();
        $this->route();
    }

    // Routing process
    public function route()
    {
        $url = $_SERVER['REQUEST_URI'];
        $this->makeControlAction($url);

        if (!$this->sessionControl()) {
            $this->startSession();
            $this->loadLanguage();
            if (strcmp($this->controller, 'Login') != 0
                && strcmp($this->controller, 'SignIn') != 0
                && strcmp($this->controller, 'Func') != 0) {
                $this->controller = $this->config['defaultController'];
                $this->action = $this->config['defaultAction'];
            }
        }

        // Check if controllers and funtion exist
        $controller = 'app\\controllers\\'. $this->controller . 'Controller';
        if (!class_exists($controller)) {
            exit($this->controller . 'The controller does not exist');
        }
        if (!method_exists($controller, $this->action)) {
            exit($this->action . 'The function does not exist');
        }
        $_SESSION['last_action'] = time();
        $dispatch = new $controller($this->controller, $this->action);

        call_user_func_array(array($dispatch, $this->action), $this->parameter);

    }

    // Test development environment
    public function setReporting()
    {
        if (APP_DEBUG === true) {
            error_reporting(E_ALL);
            ini_set('display_errors','On');
        } else {
            error_reporting(E_ALL);
            ini_set('display_errors','Off');
            ini_set('log_errors', 'On');
        }
    }

    // Delete sensitive characters
    public function deleteSlashes($value)
    {
        $value = is_array($value) ? array_map(array($this, 'deleteSlashes'), $value) : stripslashes($value);
        return $value;
    }

    // Detect and delete sensitive characters
    public function removeMagicQuotes()
    {
        if (get_magic_quotes_gpc()) {
            $_GET = isset($_GET) ? $this->deleteSlashes($_GET ) : '';
            $_POST = isset($_POST) ? $this->deleteSlashes($_POST ) : '';
            $_COOKIE = isset($_COOKIE) ? $this->deleteSlashes($_COOKIE) : '';
            $_SESSION = isset($_SESSION) ? $this->deleteSlashes($_SESSION) : '';
        }
    }

    // Detect custom global variables and remove them. Because register_globals is deprecated, if
    // the deprecated register_globals directive is set to on, then the local variable will also
    // available in the global scope of the script. For example, $_POST['foo'] will also be $foo
    // the form exists, so writing is a bad implementation that affects other variables in the code. Related Information,
    // https://www.php.net/manual/en/faq.using.php#faq.register-globals
    public function unregisterGlobals()
    {
        if (ini_get('register_globals')) {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            foreach ($array as $value) {
                foreach ($GLOBALS[$value] as $key => $var) {
                    if ($var === $GLOBALS[$key]) {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
    }

    //Configuring database information
    public function setDbConfig()
    {
        if ($this->config['db']) {
            define('DB_HOST', $this->config['db']['host']);
            define('DB_NAME', $this->config['db']['dbname']);
            define('DB_USER', $this->config['db']['username']);
            define('DB_PASS', $this->config['db']['password']);
        }
    }

    // Automatic loading class
    public function loadClass($className)
    {
        $classMap = $this->classMap();

        if (isset($classMap[$className])) {
            // Contains kernel files
            $file = $classMap[$className];
        } elseif (strpos($className, '\\') !== false) {
            // Contains the application (application directory) file
            $file = APP_PATH . str_replace('\\', '/', $className) . '.php';
            if (!is_file($file)) {
                return;
            }
        } else {
            return;
        }

        include $file;
    }

    // Kernel file namespace mapping
    protected function classMap()
    {
        return [
            'core\base\Controller' => CORE_PATH . '/base/Controller.php',
            'core\base\Model' => CORE_PATH . '/base/Model.php',
            'core\base\View' => CORE_PATH . '/base/View.php',
            'core\db\MyDb' => CORE_PATH . '/db/MyDb.php',
            'core\db\Sql' => CORE_PATH . '/db/Sql.php',
        ];
    }

    protected function startSession () {
        if(!$this->sessionStatus()) {
            session_start();
        }
    }

    protected function sessionControl () {
        //var_dump($_SESSION);
        if (isset($_SESSION['user_id'])) {
            $expire = $this->config['session']['expire'];
            //From the last action time to the current length of time
            $secondsInactive = time() - $_SESSION['last_action'];
            // Check if the last action time is greater than the specified validity period
            if ($secondsInactive >= $expire) {
                //User has not acted for too long (greater than the expiration date), delete the session
                session_unset();
                session_destroy();
                return false;
            } else {
                return true;
            }
        }
        else {
            return false;
        }
    }

    protected function loadLanguage() {
        if(!isset($_SESSION['ini_array'])) {
            $data = file_get_contents('config/language.json');
            $_SESSION['ini_array'] = json_decode($data, true);
        }

    }

    private function sessionStatus() {
        return session_status() === PHP_SESSION_ACTIVE ? true:false;
    }

    private function makeControlAction($url) {

        $controllerName = $this->config['defaultController'];
        $actionName = $this->config['defaultAction'];

        $position = strpos($url, '?');
        $url = $position === false ? $url : substr($url, 0, $position);

        // Make it possible to access index.php/{controller}/{action}
        $position = strpos($url, 'index.php');
        if ($position !== false) {
            $url = substr($url, $position + strlen('index.php'));
        }

        // Delete “/” before and after
        $url = trim($url, '/');

        if ($url) {
            // Split the string with "/" and save it in an array
            $urlArray = explode('/', $url);
            // Delete empty array elements
            $urlArray = array_filter($urlArray);

            // Get the name of the controller
            $this->controller = ucfirst($urlArray[0]);

            // Get the name of the action
            array_shift($urlArray);
            $this->action = $urlArray ? $urlArray[0] : $actionName;

            // Get URL parameters
            array_shift($urlArray);
            $this->parameter = $urlArray ? $urlArray : array();

        }
    }
}