<?php
namespace Reporter\modules\database\dao;

class UserDAO extends \Reporter\modules\database\Connector {

    private static $_resultSet = array();

    public static function getUser ($username, $password) {
        $query = 'SELECT *
            FROM users
            WHERE user_name = "' . $username . '"
            AND user_password = "' . $password . '"
            AND user_status = 1';

        $results = self::_execute($query);

        if ($results) {
            foreach ($results as $one) {
                $tmpResult = new \Reporter\modules\database\vo\UserVO();
                $tmpResult->setID($one->user_id);
                $tmpResult->setName($one->user_name);
                $tmpResult->setPassword($one->user_password);
                $tmpResult->setEmail($one->user_email);
                $tmpResult->setRealName($one->user_real_name);
                $tmpResult->setLastName($one->user_last_name);
                $tmpResult->setToken($one->user_token);
                $tmpResult->setLastSeen($one->user_last_seen);
                $tmpResult->setStatus($one->user_status);

                self::$_resultSet[] = $tmpResult;
            }
        }

        return self::$_resultSet;
    }

}
