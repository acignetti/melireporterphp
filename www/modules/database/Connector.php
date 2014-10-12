<?php
namespace Reporter\modules\database;

class Connector {

    private static $_dbInstance;

    private static function _openConnection() {
        if (!self::$_dbInstance) {
            self::$_dbInstance = new \mysqli(__HOST__, __USER__, __PASS__, __BASE__);
        }
    }

    private static function _closeConnection() {
        if (self::$_dbInstance) {
            mysqli_close(self::$_dbInstance);
        }
    }

    protected static function _execute ($query) {
        $resultSet = false;

        self::_openConnection();

        $result = mysqli_query(self::$_dbInstance, $query);

        if ($result) {
            $resultSet = array();

            while ($aRow = mysqli_fetch_object($result)) {
                $resultSet[] = $aRow;
            }
        }

        self::_closeConnection();

        return $resultSet;
    }

}
