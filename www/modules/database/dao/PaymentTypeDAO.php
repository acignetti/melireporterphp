<?php
namespace Reporter\modules\database\dao;

class PaymentTypeDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    public static function getPayments($id = null) {
        $query = 'SELECT * FROM payment_type';

        if ($id !== null) {
            $query .= ' WHERE payment_id = ' . $id;
        }

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\PaymentTypeVO();
                $tmpResult->setID($one->payment_id);
                $tmpResult->setName($one->payment_name);
                $tmpResult->setDescription($one->payment_description);
                $tmpResult->setStatus($one->payment_status);
                $tmpResult->setCategory($one->payment_category);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function save(\Reporter\modules\database\vo\PaymentTypeVO & $valueObject) {
        if ($valueObject->getID()) {
            $query  = 'UPDATE payment_type SET ';
        } else {
            $query  = 'INSERT INTO payment_type (payment_name, payment_description, payment_category) VALUES ';
            $query .= "('{$valueObject->getName()}','{$valueObject->getDescription()}','{$valueObject->getCategory()}')";
        }

        self::_execute($query);

        if (self::$_insertID) {
            $valueObject->setID(self::$_insertID);
        }
    }
}
