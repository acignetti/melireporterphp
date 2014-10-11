<?php
namespace Reporter\modules\core;

class General {

    public static function createResponse ($success, $message, $optional = null) {
        $toReturn = new \stdClass;
        $toReturn->success = $success;
        $toReturn->message = $message;

        if ($optional) {
            $toReturn->optional = $optional;
        }

        return json_encode($toReturn);
    }

}
