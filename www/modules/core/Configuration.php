<?php
namespace Reporter\modules\core;

class Configuration {

    public static function loadConfiguration() {
        if (!defined('__ROOT__'))  define('__ROOT__', dirname(__FILE__) . '/../../');
        if (!defined('__USERS__')) define('__USERS__', __ROOT__ . 'logged_users/');

        /**
         * Related to database
         */
        if (!defined('__USER__')) define('__USER__', 'melireporter');
        if (!defined('__PASS__')) define('__PASS__', 'reporter');
        if (!defined('__HOST__')) define('__HOST__', '127.0.0.1');
        if (!defined('__BASE__')) define('__BASE__', 'melireport');

        /**
         * Related to MeLi
         */
        if (!defined('__COUTRY__'))    define('__COUTRY__',    'MLA');
        if (!defined('__APPID__'))     define('__APPID__',     '6283809452926869');
        if (!defined('__APPSECRET__')) define('__APPSECRET__', '7jCwBNkyhBeMiydwPNGxTiNfl1Sd4CW6');

        ini_set('display_errors', 'Off');
        ini_set('html_errors',    'Off');
    }

}
