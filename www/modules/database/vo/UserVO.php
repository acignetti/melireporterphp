<?php
namespace Reporter\modules\database\vo;

class UserVO implements \JsonSerializable {

    private $_id;
    private $_name;
    private $_password;
    private $_email;
    private $_real_name;
    private $_last_name;
    private $_token;
    private $_last_seen;
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

    public function setPassword ($newValue) {
        $this->_password = $newValue;
    }

    public function setEmail ($newValue) {
        $this->_email = $newValue;
    }

    public function setRealName ($newValue) {
        $this->_real_name = $newValue;
    }

    public function setLastName ($newValue) {
        $this->_last_name = $newValue;
    }

    public function setToken ($newValue) {
        $this->_token = $newValue;
    }

    public function setLastSeen ($newValue) {
        $this->_last_seen = $newValue;
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

    public function getPassword () {
        return $this->_password;
    }

    public function getEmail () {
        return $this->_email;
    }

    public function getRealName () {
        return $this->_real_name;
    }

    public function getLastName () {
        return $this->_last_name;
    }

    public function getToken () {
        return $this->_token;
    }

    public function getLastSeen () {
        return $this->_last_seen;
    }

    public function getStatus () {
        return $this->_status;
    }

    public function getObject() {
        $toReturn = new \stdClass;

        $toReturn->user_id        = $this->_id;
        $toReturn->user_name      = $this->_name;
        $toReturn->user_password  = $this->_password;
        $toReturn->user_email     = $this->_email;
        $toReturn->user_real_name = $this->_real_name;
        $toReturn->user_last_name = $this->_last_name;
        $toReturn->user_token     = $this->_token;
        $toReturn->user_last_seen = $this->_last_seen;
        $toReturn->user_status    = $this->_status;

        return $toReturn;
    }

}
