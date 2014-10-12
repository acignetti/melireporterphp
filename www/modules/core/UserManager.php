<?php
namespace Reporter\modules\core;

class UserManager {

    private static function setUserAccessToken($username, $newAccessToken) {
        if (!file_exists(__USERS__ . $newAccessToken)) {
            file_put_contents(__USERS__ . $newAccessToken, $username);
        }
    }

    public static function validateUser($username, $accessToken) {
        if (file_exists(__USERS__ . $accessToken)) {
            $currentUser = file_get_contents(__USERS__ . $accessToken);
            if ($currentUser == $username) {
                return;
            }
        }

        echo General::createResponse(false, 'Access denied', 'Access token is invalid');
        exit;
    }

    public static function logOut($accessToken) {
        unlink(__USERS__ . $accessToken);
    }

    public static function logIn($username, $password) {
        $validUser = \Reporter\modules\database\dao\UserDAO::getUser($username, $password);

        if ($validUser) {
            $validUser[0]->setLastSeen(date('Y-m-d H:i:s'));

            $newUserAccessToken = md5(microtime() . $validUser[0]->getLastSeen());

            self::setUserAccessToken($validUser[0]->getName(), $newUserAccessToken);

            return General::createResponse(true, 'Access granted', $newUserAccessToken);
        }

        return General::createResponse(false, 'Access denied', 'Username or password are invalid');
    }

    public static function registerAccessToken($username, $accessToken) {
        $currentUser = \Reporter\modules\database\dao\UserDAO::getUserByID($username);
        $currentUser[0]->setToken($accessToken);

        \Reporter\modules\database\dao\UserDAO::save($currentUser[0]);

        return General::createResponse(true, "Token saved correctly");
    }

}
