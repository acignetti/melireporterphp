<?php
namespace Reporter\modules\database\dao;

class ItemDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    public static function getItems($id = null) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM items';

        if ($id !== 0) {
            $query = 'SELECT * FROM items WHERE item_synced = 0';
        }

        if ($id !== null) {
            $query .= ' WHERE item_id = ' . $id;
        }

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\ItemVO();
                $tmpResult->setID($one->item_id);
                $tmpResult->setMLID($one->item_ml_id);
                $tmpResult->setName($one->item_name);
                $tmpResult->setDescription($one->item_description);
                $tmpResult->setThumbnail($one->item_thumbnail);
                $tmpResult->setPrice($one->item_price);
                $tmpResult->setCost($one->item_cost);
                $tmpResult->setPublishedOn($one->item_published_on);
                $tmpResult->setEndedOn($one->item_ended_on);
                $tmpResult->setCategoryId($one->item_category_id);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function getItemByMLID($mlID) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM items WHERE item_ml_ID = "' . $mlID . '"';

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\ItemVO();
                $tmpResult->setID($one->item_id);
                $tmpResult->setMLID($one->item_ml_id);
                $tmpResult->setName($one->item_name);
                $tmpResult->setDescription($one->item_description);
                $tmpResult->setThumbnail($one->item_thumbnail);
                $tmpResult->setPrice($one->item_price);
                $tmpResult->setCost($one->item_cost);
                $tmpResult->setPublishedOn($one->item_published_on);
                $tmpResult->setEndedOn($one->item_ended_on);
                $tmpResult->setCategoryId($one->item_category_id);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function save(\Reporter\modules\database\vo\ItemVO & $valueObject) {
        $oldValue = self::getItemByMLID($valueObject->getMLID());

        if ($oldValue) {
            $query  = "UPDATE items SET item_name = '{$valueObject->getName()}',".
                " item_description = '{$valueObject->getDescription()}',".
                " item_thumbnail = '{$valueObject->getThumbnail()}',".
                " item_price = '{$valueObject->getPrice()}',".
                " item_cost = '{$valueObject->getCost()}',".
                " item_published_on = '{$valueObject->getPublishedOn()}',".
                " item_ended_on = '{$valueObject->getEndedOn()}',".
                " item_category_id = '{$valueObject->getCategoryId()}'".
                " WHERE item_id = '{$oldValue[0]->getID()}'";
            $valueObject->setID($oldValue[0]->getID());
        } else {
            $query  = "INSERT INTO items (item_ml_id, item_name, item_description, ".
                "item_thumbnail, item_price, item_cost, item_published_on, item_ended_on, item_category_id) " .
                "VALUES ('{$valueObject->getMLID()}','{$valueObject->getName()}',".
                "'{$valueObject->getDescription()}','{$valueObject->getThumbnail()}',".
                "'{$valueObject->getPrice()}','{$valueObject->getCost()}','{$valueObject->getPublishedOn()}',".
                "'{$valueObject->getEndedOn()}','{$valueObject->getCategoryId()}')";
        }

        self::_execute($query);

        if (self::$_insertID) {
            $valueObject->setID(self::$_insertID);
        }
    }

}
