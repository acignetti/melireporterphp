<?php
namespace Reporter\modules\database\vo;

class BuyerVO implements \JsonSerializable {

    private $_id;
    private $_ml_id;
    private $_name;
    private $_last_name;
    private $_email;
    private $_address;
    private $_synced;

    public function __tostring() {
        return json_encode($this->getObject());
    }

    public function jsonSerialize() {
        return $this->getObject();
    }

    public function wasSynced() {
        return (bool) $this->_synced;
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

    public function setLastName ($newValue) {
        $this->_last_name = $newValue;
    }

    public function setEmail ($newValue) {
        $this->_email = $newValue;
    }

    public function setAddress ($newValue) {
        $this->_address = $newValue;
    }

    public function setSynced ($newValue) {
        $this->_synced = $newValue;
    }

    public function getID ($newValue) {
        return $this->_id;
    }

    public function getMLID ($newValue) {
        return $this->_ml_id;
    }

    public function getName ($newValue) {
        return $this->_name;
    }

    public function getLastName ($newValue) {
        return $this->_last_name;
    }

    public function getEmail ($newValue) {
        return $this->_email;
    }

    public function getAddress ($newValue) {
        return $this->_address;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->buyer_id        = $this->_id;
        $toReturn->buyer_name      = $this->_name;
        $toReturn->buyer_last_name = $this->_last_name;
        $toReturn->buyer_email     = $this->_email;
        $toReturn->buyer_address   = $this->_address;

        return $toReturn;
    }

}
