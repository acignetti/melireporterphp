<?php
namespace Reporter\modules\core;

class General {

    public static function createResponse ($success, $message, $optional = null, $values = null) {
        $toReturn = new \stdClass;
        $toReturn->success = $success;
        $toReturn->message = $message;

        if ($values !== null) {
            $toReturn->optional = new \stdClass;
            $toReturn->optional->$optional = $values;
        } elseif ($optional) {
            $toReturn->optional = $optional;
        }

        return json_encode($toReturn);
    }

}
