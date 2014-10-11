<?php
namespace Reporter\modules\database\vo;

class SaleVO implements \JsonSerializable {

    private $_id;
    private $_user_id;
    private $_item_id;
    private $_payment_id;
    private $_quantity;
    private $_bought_on;
    private $_paid_on;
    private $_status;
    private $_total;
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

    public function setUserId ($newValue) {
        $this->_user_id = $newValue;
    }

    public function setItemId ($newValue) {
        $this->_item_id = $newValue;
    }

    public function setPaymentId ($newValue) {
        $this->_payment_id = $newValue;
    }

    public function setQuantity ($newValue) {
        $this->_quantity = $newValue;
    }

    public function setBoughtOn ($newValue) {
        $this->_bought_on = $newValue;
    }

    public function setPaidOn ($newValue) {
        $this->_paid_on = $newValue;
    }

    public function setStatus ($newValue) {
        $this->_status = $newValue;
    }

    public function setTotal ($newValue) {
        $this->_total = $newValue;
    }

    public function getID () {
        return $this->_id;
    }

    public function getUserId () {
        return $this->_user_id;
    }

    public function getItemId () {
        return $this->_item_id;
    }

    public function getPaymentId () {
        return $this->_payment_id;
    }

    public function getQuantity () {
        return $this->_quantity;
    }

    public function getBoughtOn () {
        return $this->_bought_on;
    }

    public function getPaidOn () {
        return $this->_paid_on;
    }

    public function getStatus () {
        return $this->_status;
    }

    public function getTotal () {
        return $this->_total;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->sale_id         = $this->_id;
        $toReturn->sale_user_id    = $this->_user_id;
        $toReturn->sale_item_id    = $this->_item_id;
        $toReturn->sale_payment_id = $this->_payment_id;
        $toReturn->sale_quantity   = $this->_quantity;
        $toReturn->sale_bought_on  = $this->_bought_on;
        $toReturn->sale_paid_on    = $this->_paid_on;
        $toReturn->sale_status     = $this->_status;
        $toReturn->sale_total      = $this->_total;

        return $toReturn;
    }

}
