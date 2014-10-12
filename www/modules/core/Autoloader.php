<?php
namespace Reporter\modules\core;

class Autoloader {

    public static function autoload($className) {
        $realClass = str_replace('\\', '/', $className);
        $fileName  = str_replace('Reporter/', '', $realClass) . '.php';

        if (file_exists(__ROOT__ . $fileName)) {
            require __ROOT__ . $fileName;
        }
    }

}