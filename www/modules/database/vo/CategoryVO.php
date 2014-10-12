<?php
namespace Reporter\modules\database\vo;

class CategoryVO implements \JsonSerializable {

    private $_id;
    private $_ml_id;
    private $_name;
    private $_description;
    private $_father = 0;
    private $_status;

    public function __tostring() {
        return json_encode($this->getObject());
    }

    public function jsonSerialize() {
        return $this->getObject();
    }

    public function setID ($newValue) {
        $this->_id = $newValue;
    }

    public function setMLID ($newValue) {
        $this->_ml_id = $newValue;
    }

    public function setName ($newValue) {
        $this->_name = $newValue;
    }

    public function setDescription ($newValue) {
        $this->_description = $newValue;
    }

    public function setFather ($newValue) {
        $this->_father = $newValue;
    }

    public function setStatus ($newValue) {
        $this->_status = (bool) $newValue;
    }

    public function getID () {
        return $this->_id;
    }

    public function getMLID () {
        return $this->_ml_id;
    }

    public function getName () {
        return $this->_name;
    }

    public function getDescription () {
        return $this->_description;
    }

    public function getFather () {
        return $this->_father;
    }

    public function getStatus () {
        return $this->_status;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->category_id          = $this->_id;
        $toReturn->category_name        = $this->_name;
        $toReturn->category_description = $this->_description;
        $toReturn->category_father      = $this->_father;
        $toReturn->category_status      = $this->_status;

        return $toReturn;
    }

}
