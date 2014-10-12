<?php
namespace Reporter\modules\database\dao;

class CategoryDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    public static function getCategories($id = null) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM categories WHERE category_father = ';

        if ($id !== null) {
            $query .= $id;
        } else {
            $query .= 0;
        }

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\CategoryVO();
                $tmpResult->setID($one->category_id);
                $tmpResult->setName($one->category_name);
                $tmpResult->setDescription($one->category_description);
                $tmpResult->setFather($one->category_father);
                $tmpResult->setStatus($one->category_status);
                $tmpResult->setMLID($one->category_ml_id);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function getCategoriesByMLID($mlID) {
        self::$_resultSet = array();

        $query = 'SELECT * FROM categories WHERE category_ml_id = "' . $mlID . '"';

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\CategoryVO();
                $tmpResult->setID($one->category_id);
                $tmpResult->setName($one->category_name);
                $tmpResult->setDescription($one->category_description);
                $tmpResult->setFather($one->category_father);
                $tmpResult->setStatus($one->category_status);
                $tmpResult->setMLID($one->category_ml_id);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

    public static function save(\Reporter\modules\database\vo\CategoryVO & $valueObject) {
        if ($valueObject->getID()) {
            $query  = 'UPDATE categories SET blah blah';
        } else {
            $query  = 'INSERT INTO categories (category_ml_id, category_name, category_father) VALUES ';
            $query .= "('{$valueObject->getMLID()}','{$valueObject->getName()}','{$valueObject->getFather()}')";
        }

        self::_execute($query);

        if (self::$_insertID) {
            $valueObject->setID(self::$_insertID);
        }
    }

}
