<?php
namespace Reporter\modules\database;

class Connector {

    private static $_dbInstance;

    protected static $_affectedRows;
    protected static $_insertID;

    private static function _openConnection() {
        if (!self::$_dbInstance) {
            self::$_dbInstance = new \mysqli(__HOST__, __USER__, __PASS__, __BASE__);
        }
    }

    private static function _closeConnection() {
        if (self::$_dbInstance) {
            mysqli_close(self::$_dbInstance);
            self::$_dbInstance = null;
        }
    }

    protected static function _execute ($query) {
        $resultSet = false;

        self::_openConnection();

        $result = mysqli_query(self::$_dbInstance, $query);

        if ($result !== true && $result !== false) {
            $resultSet = array();

            while ($aRow = mysqli_fetch_object($result)) {
                $resultSet[] = $aRow;
            }
        }

        if (mysqli_insert_id(self::$_dbInstance)) {
            self::$_insertID = mysqli_insert_id(self::$_dbInstance);
        }

        if (mysqli_affected_rows(self::$_dbInstance)) {
            self::$_affectedRows = mysqli_affected_rows(self::$_dbInstance);
        }

        self::_closeConnection();

        return $resultSet;
    }

}
