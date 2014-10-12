<?php
header('Content-Type: application/json');

define('__MAIN__',    dirname(__FILE__) . '/modules/');
define('__SLIM__',    dirname(__FILE__) . '/modules/Slim/');

require __MAIN__ . 'Main.php';
require __SLIM__ . 'Slim.php';

Reporter\modules\Main::setUpEnvironment();
Reporter\modules\Main::loadRoutes();
