<?php
namespace Reporter\modules\core;

class UserManager {

    const _ITEMS   = 'https://api.mercadolibre.com/users/{user_ml_id}/items/search?access_token={user_token}';
    const _ITEM    = 'https://api.mercadolibre.com/items/{item_ml_id}';
    const _IT_DESC = 'https://api.mercadolibre.com/items/{item_ml_id}/description';

    const _ORDERS  = 'https://api.mercadolibre.com/orders/search?seller={user_ml_id}&access_token={access_token}';

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

    public static function registerAccessToken($username, $accessToken, $userMLID) {
        $currentUser = \Reporter\modules\database\dao\UserDAO::getUserByID($username);
        $currentUser[0]->setToken($accessToken);
        $currentUser[0]->setMLID($userMLID);

        \Reporter\modules\database\dao\UserDAO::save($currentUser[0]);

        return General::createResponse(true, "Token saved correctly");
    }

    public static function processUserItems($meliInstance, $userMLID, $accessToken) {
        $new = [$userMLID, $accessToken];
        $old = ['{user_ml_id}', '{user_token}'];

        $url = str_replace($old, $new, self::_ITEMS);

        $items = $meliInstance->get($url)['body']->results;

        foreach ($items as $anItem) {
            $url         = str_replace('{item_ml_id}', $anItem, self::_ITEM);
            $information = $meliInstance->get($url);

            $current = new \Reporter\modules\database\vo\ItemVO;
            $current->setMLID($anItem);
            $current->setCost(0);
            $current->setName($information->title);
            $current->setPrice($information->base_price);
            $current->setThumbnail($information->thumbnail);

            $categoryVO = \Reporter\modules\database\dao\CategoryDAO::getCategoriesByMLID($information->category_id);

            $current->setCategoryId($categoryVO->getID());
            $current->setEndedOn($information->start_time);
            $current->setPublishedOn($information->stop_time);

            $url         = str_replace('{item_ml_id}', $anItem, self::_IT_DESC);
            $information = $meliInstance->get($url);

            if ($information->text) {
                $current->setDescription($information->text);
            } else {
                $current->setDescription($information->plain_text);
            }

            \Reporter\modules\database\dao\ItemDAO::save($current);
        }
    }

    public static function processUserOrders($meliInstance, $userMLID, $accessToken) {
        $new = [$userMLID, $accessToken];
        $old = ['{user_ml_id}', '{user_token}'];

        $url = str_replace($old, $new, self::_ITEMS);

        $items = $meliInstance->get($url)['body']->results;

        foreach ($items as $anItem) {
            $url         = str_replace('{item_ml_id}', $anItem, self::_ITEM);
            $information = $meliInstance->get($url);

            $current = new \Reporter\modules\database\vo\ItemVO;
            $current->setMLID($anItem);
            $current->setCost(0);
            $current->setName($information->title);
            $current->setPrice($information->base_price);
            $current->setThumbnail($information->thumbnail);

            $categoryVO = \Reporter\modules\database\dao\CategoryDAO::getCategoriesByMLID($information->category_id);

            $current->setCategoryId($categoryVO->getID());
            $current->setEndedOn($information->start_time);
            $current->setPublishedOn($information->stop_time);

            $url         = str_replace('{item_ml_id}', $anItem, self::_IT_DESC);
            $information = $meliInstance->get($url);

            if ($information->text) {
                $current->setDescription($information->text);
            } else {
                $current->setDescription($information->plain_text);
            }

            \Reporter\modules\database\dao\ItemDAO::save($current);
        }
    }

}
