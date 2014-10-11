<?php
namespace Reporter\modules\database\vo;

class PaymentTypeVO implements \JsonSerializable {

    private $_id;
    private $_name;
    private $_description;
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

    public function setName ($newValue) {
        $this->_name = $newValue;
    }

    public function setDescription ($newValue) {
        $this->_description = $newValue;
    }

    public function setStatus ($newValue) {
        $this->_status = $newValue;
    }

    public function getID () {
        return $this->_id;
    }

    public function getName () {
        return $this->_name;
    }

    public function getDescription () {
        return $this->_description;
    }

    public function getStatus () {
        return $this->_status;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->payment_id          = $this->_id;
        $toReturn->payment_name        = $this->_name;
        $toReturn->payment_description = $this->_description;
        $toReturn->payment_status      = $this->_status;

        return $toReturn;
    }

}
