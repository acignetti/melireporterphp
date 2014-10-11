<?php
namespace Reporter\modules\database\vo;

class ItemVO implements \JsonSerializable {

    private $_id;
    private $_ml_id;
    private $_name;
    private $_description;
    private $_thumbnail;
    private $_price;
    private $_cost;
    private $_published_on;
    private $_ended_on;
    private $_category_id;
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

    public function setDescription ($newValue) {
        $this->_description = $newValue;
    }

    public function setThumbnail ($newValue) {
        $this->_thumbnail = $newValue;
    }

    public function setPrice ($newValue) {
        $this->_price = $newValue;
    }

    public function setCost ($newValue) {
        $this->_cost = $newValue;
    }

    public function setPublishedOn ($newValue) {
        $this->_published_on = $newValue;
    }

    public function setEndedOn ($newValue) {
        $this->_ended_on = $newValue;
    }

    public function setCategoryId ($newValue) {
        $this->_category_id = $newValue;
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

    public function getThumbnail () {
        return $this->_thumbnail;
    }

    public function getPrice () {
        return $this->_price;
    }

    public function getCost () {
        return $this->_cost;
    }

    public function getPublishedOn () {
        return $this->_published_on;
    }

    public function getEndedOn () {
        return $this->_ended_on;
    }

    public function getCategoryId () {
        return $this->_category_id;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->item_id           = $this->_id;
        $toReturn->item_name         = $this->_name;
        $toReturn->item_description  = $this->_description;
        $toReturn->item_thumbnail    = $this->_thumbnail;
        $toReturn->item_price        = $this->_price;
        $toReturn->item_cost         = $this->_cost;
        $toReturn->item_published_on = $this->_published_on;
        $toReturn->item_ended_on     = $this->_ended_on;
        $toReturn->item_category_id  = $this->_category_id;

        return $toReturn;
    }
}