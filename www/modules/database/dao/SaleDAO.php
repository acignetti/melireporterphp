<?php
namespace Reporter\modules\database\dao;

class SaleDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    private $_id;
    private $_ml_id;
    private $_user_id;
    private $_item_id;
    private $_buyer_id;
    private $_payment_id;
    private $_quantity;
    private $_bought_on;
    private $_paid_on;
    private $_status;
    private $_total;
    private $_synced;

    public static function getSales($id = null) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM sales';

        if ($id != 0) {
            $query = 'SELECT * FROM sales WHERE sale_synced = 0';
        }

        if ($id !== null) {
            $query .= ' WHERE sale_id = ' . $id;
        }

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\SaleVO();
                $tmpResult->setID($one->sale_id);
                $tmpResult->setMLID($one->sale_ml_id);
                $tmpResult->setUserId($one->sale_user_id);
                $tmpResult->setItemId($one->sale_item_id);
                $tmpResult->setBuyerId($one->sale_buyer_id);
                $tmpResult->setPaymentId($one->sale_payment_id);
                $tmpResult->setQuantity($one->sale_quantity);
                $tmpResult->setBoughtOn($one->sale_bought_on);
                $tmpResult->setPaidOn($one->sale_paid_on);
                $tmpResult->setStatus($one->sale_status);
                $tmpResult->setTotal($one->sale_total);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function getSaleByMLID($mlID) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM sales WHERE sale_ml_id = ' . $mlID;

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\SaleVO();
                $tmpResult->setID($one->sale_id);
                $tmpResult->setMLID($one->sale_ml_id);
                $tmpResult->setUserId($one->sale_user_id);
                $tmpResult->setItemId($one->sale_item_id);
                $tmpResult->setBuyerId($one->sale_buyer_id);
                $tmpResult->setPaymentId($one->sale_payment_id);
                $tmpResult->setQuantity($one->sale_quantity);
                $tmpResult->setBoughtOn($one->sale_bought_on);
                $tmpResult->setPaidOn($one->sale_paid_on);
                $tmpResult->setStatus($one->sale_status);
                $tmpResult->setTotal($one->sale_total);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function save(\Reporter\modules\database\vo\SaleVO & $valueObject) {
        $oldValue = self::getSaleByMLID($valueObject->getMLID());

        if ($oldValue) {
            $query = "UPDATE sales SET sale_user_id = '{$valueObject->getUserId()}',".
                " sale_item_id = '{$valueObject->getItemId()}',".
                " sale_buyer_id = '{$valueObject->getBuyerId()}',".
                " sale_payment_id = '{$valueObject->getPaymentId()}',".
                " sale_quantity = '{$valueObject->getQuantity()}',".
                " sale_bought_on = '{$valueObject->getBoughtOn()}',".
                " sale_paid_on = '{$valueObject->getPaidOn()}',".
                " sale_status = '{$valueObject->getStatus()}',".
                " sale_total = '{$valueObject->getTotal()}'".
                " WHERE sale_ml_id = '{$oldValue[0]->getMLID()}'";
            $valueObject->setID($oldValue[0]->getID());
        } else {
            $query = "INSERT INTO sales (sale_ml_id, sale_user_id, sale_item_id, sale_buyer_id, ".
                "sale_payment_id, sale_quantity, sale_bought_on, sale_paid_on, sale_status, sale_total)".
                "VALUES ('{$valueObject->getMLID()}','{$valueObject->getUserId()}',".
                "'{$valueObject->getItemId()}','{$valueObject->getBuyerId()}',".
                "'{$valueObject->getPaymentId()}','{$valueObject->getQuantity()}',".
                "'{$valueObject->getBoughtOn()}','{$valueObject->getPaidOn()}',".
                "'{$valueObject->getStatus()}','{$valueObject->getTotal()}')";
        }

        self::_execute($query);

        if (self::$_insertID) {
            $valueObject->setID(self::$_insertID);
        }
    }

}
