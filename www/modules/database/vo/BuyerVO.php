<?php
namespace Reporter\modules\database\vo;

class BuyerVO implements \JsonSerializable {

    private $_id;
    private $_ml_id;
    private $_name;
    private $_real_name;
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

    public function setRealName ($newValue) {
        $this->_real_name = $newValue;
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

    public function getID () {
        return $this->_id;
    }

    public function getMLID () {
        return $this->_ml_id;
    }

    public function getName () {
        return $this->_name;
    }

    public function getLastName () {
        return $this->_last_name;
    }

    public function getRealName () {
        return $this->_real_name;
    }

    public function getEmail () {
        return $this->_email;
    }

    public function getAddress () {
        return $this->_address;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->buyer_id        = $this->_id;
        $toReturn->buyer_name      = $this->_name;
        $toReturn->buyer_real_name = $this->_real_name;
        $toReturn->buyer_last_name = $this->_last_name;
        $toReturn->buyer_email     = $this->_email;
        $toReturn->buyer_address   = $this->_address;

        return $toReturn;
    }

}
