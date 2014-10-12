<?php
namespace Reporter\modules\database\dao;

class BuyerDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    public static function getBuyers($id = null) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM buyers';

        if ($id != 0) {
            $query = 'SELECT * FROM buyers WHERE buyer_synced = 0';
        }

        if ($id !== null) {
            $query .= ' WHERE buyer_id = ' . $id;
        }

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\BuyerVO();
                $tmpResult->setID($one->buyer_id);
                $tmpResult->setMLID($one->buyer_ml_id);
                $tmpResult->setName($one->buyer_name);
                $tmpResult->setRealName($one->buyer_real_name);
                $tmpResult->setLastName($one->buyer_last_name);
                $tmpResult->setEmail($one->buyer_email);
                $tmpResult->setAddress($one->buyer_address);
                // $tmpResult->setSynced($one->buyer_synced);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function getBuyerByMLID($mlID) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM buyers WHERE buyer_ml_id = "' . $mlID . '"';

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\BuyerVO();
                $tmpResult->setID($one->buyer_id);
                $tmpResult->setMLID($one->buyer_ml_id);
                $tmpResult->setName($one->buyer_name);
                $tmpResult->setRealName($one->buyer_real_name);
                $tmpResult->setLastName($one->buyer_last_name);
                $tmpResult->setEmail($one->buyer_email);
                $tmpResult->setAddress($one->buyer_address);
                // $tmpResult->setSynced($one->buyer_synced);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function save(\Reporter\modules\database\vo\BuyerVO & $valueObject) {
        $oldValue = self::getBuyerByMLID($valueObject->getMLID());

        if ($oldValue) {
            $query  = "UPDATE buyers SET buyer_name = '{$valueObject->getName()}',".
                " buyer_real_name = '{$valueObject->getRealName()}',".
                " buyer_last_name = '{$valueObject->getLastName()}',".
                " buyer_email = '{$valueObject->getEmail()}',".
                " buyer_address = '{$valueObject->getAddress()}'".
                " WHERE buyer_id = '{$oldValue[0]->getID()}' ";
            $valueObject->setID($oldValue[0]->getID());
        } else {
            $query  = "INSERT INTO buyers (buyer_ml_id, buyer_name, buyer_real_name,".
                " buyer_last_name, buyer_email, buyer_address) VALUES (".
                " '{$valueObject->getMLID()}', '{$valueObject->getName()}',".
                " '{$valueObject->getRealName()}', '{$valueObject->getLastName()}',".
                " '{$valueObject->getEmail()}', '{$valueObject->getAddress()}')";
        }

        self::_execute($query);

        if (self::$_insertID) {
            $valueObject->setID(self::$_insertID);
        }
    }

}
