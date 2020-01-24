<?php

define("DEBUG", true);
define("ROOT", dirname(__DIR__));
define("CONF", ROOT . '/config');
define("ROUTES", ROOT . '/routes');
define("CORE", ROOT . '/vendor/core');
define("CONTROLLERS", ROOT . '/src/Http/Controllers');

require_once ROOT . "/vendor/autoload.php";
