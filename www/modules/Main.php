<?php
namespace Reporter\modules;

require __DIR__ . '/core/Configuration.php';
require __DIR__ . '/core/Autoloader.php';
require __DIR__ . '/core/meli.php';

class Main {

    private static $_slimInstance;

    private static function loadPostRoutes() {
        /**
         * Login, echoes user access token for this session
         */
        self::$_slimInstance->post('/user/:username/:password', function ($username, $password) {
            echo self::processRequest(
                'login',
                [
                    'username' => $username,
                    'password' => $password
                ]
            );
        });
    }

    private static function loadGetRoutes() {

        /**
         * I couldn't use MeLi api to send me the code through POST so I use get
         * This function loads all the user data into our DB
         */
        self::$_slimInstance->get('/user/:username/:access_token/appID', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            echo self::processRequest(
                'updateUserData',
                [
                    "username"    => $username,
                    "accessToken" => $accessToken
                ]
            );
         });

        /**
         * Item list for current user
         */
        self::$_slimInstance->get('/item/:username/:access_token', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'Item list',
                'items',
                database\dao\ItemDAO::getItems($username)
            );
        });

        /**
         * One item information if belongs to current user
         */
        self::$_slimInstance->get('/item/:username/:access_token/:id', function($username, $accessToken, $id) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'One item',
                'items',
                database\dao\ItemDAO::getItems($username, $id)
            );
        });

        /**
         * Retrieves all categories, no need for user
         */
        self::$_slimInstance->get('/category', function() {
            echo core\General::createResponse(
                true,
                'Category list',
                'category',
                database\dao\CategoryDAO::getCategories()
            );
        });

        /**
         * Retrieves only one category, just in case
         */
        self::$_slimInstance->get('/category/:id', function($id) {
            echo core\General::createResponse(
                true,
                'Only one category',
                'category',
                database\dao\CategoryDAO::getCategories($id)
            );
        });

        /**
         * Retrieves all payment_types, no need for user
         */
        self::$_slimInstance->get('/payment_type', function() {
            echo core\General::createResponse(
                true,
                'Payment types',
                'payment_type',
                database\dao\PaymentTypeDAO::getPayments()
            );
        });

        /**
         * Retrieves only one payment_type, just in case
         */
        self::$_slimInstance->get('/payment_type/:id', function($id) {
            echo core\General::createResponse(
                true,
                'Only one Payment type',
                'payment_type',
                database\dao\PaymentTypeDAO::getPayments($id)
            );
        });

        /**
         * Retrieves all buyers related to our client of course
         */
        self::$_slimInstance->get('/buyer/:username/:access_token', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'Your buyers',
                'buyers',
                database\dao\BuyerDAO::getBuyers($username)
            );
        });

        /**
         * Retrieves only one buyer information, if he's related to the user
         */
        self::$_slimInstance->get('/buyer/:username/:access_token/:id', function($username, $accessToken, $id) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'Your buyers',
                'buyers',
                database\dao\BuyerDAO::getBuyers($username, $id)
            );
        });

        /**
         * Current user's sale list
         */
        self::$_slimInstance->get('/sale/:username/:access_token', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'Current user\'s sale list',
                'sales',
                database\dao\SaleDAO::getSales($username)
            );
        });

        /**
         * Information about one sale, if it belongs to the user
         */
        self::$_slimInstance->get('/sale/:username/:access_token/:id', function($username, $accessToken, $id) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(
                true,
                'Current user\'s sale list',
                'sales',
                database\dao\SaleDAO::getSales($username, $id)
            );
        });

        /**
         * Our most important section of the system, reports for everyone, YAY!!
         */
        self::$_slimInstance->get('/report/:username/:access_token', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            echo core\General::createResponse(false, 'We are not functional yet :_(');
        });
    }

    private static function loadDeleteRoutes() {
        /**
         * Logout of our system, sad to see you leave :_(
         */
        self::$_slimInstance->delete('/user/:username/:access_token', function($username, $accessToken) {
            core\UserManager::validateUser($username, $accessToken);
            core\UserManager::logOut($accessToken);
            echo core\General::createResponse(true, 'It\'s hard to see you leave');
        });
    }

    private static function loadPutRoutes() {
        /**
         * We don't have any... Yet
         */
    }

    public static function setUpEnvironment() {
        \Reporter\modules\core\Configuration::loadConfiguration();
        spl_autoload_register(__NAMESPACE__ . "\\core\\Autoloader::autoload");
    }

    public static function loadRoutes() {
        try {
            \Slim\Slim::registerAutoloader();

            self::$_slimInstance  = new \Slim\Slim();

            self::$_slimInstance->response->headers->set('Content-Type', 'application/json');

            self::loadPutRoutes();
            self::loadGetRoutes();
            self::loadPostRoutes();
            self::loadDeleteRoutes();

            /**
             * Finally, we map every default route and non existent ones to a bad
             * request so we don't blow up the android app
             */
            self::$_slimInstance->map('/:nothing+', function (){
                echo self::processRequest('goToDefault');
            })->via('GET', 'POST', 'DELETE', 'PUT');

            self::$_slimInstance->run();
        } catch (Exception $general) {
            echo core\General::createResponse(false,
                'Something bad happened',
                 $general->getTraceAsString()
            );
        }
    }

    public static function processRequest($operation, $params = null) {
        switch ($operation) {
            case 'login':
                return core\UserManager::logIn(
                    $params['username'],
                    $params['password']
                );
            case 'updateUserData': {
                $meliCode = $_GET['code'];

                $meli     = new \MeLi(__APPID__, __APPSECRET__);

                /**
                 * This is because MeLi's API didn't work as it was supposed to
                 */
                $response = $meli->post(
                    "https://api.mercadolibre.com/oauth/token?" .
                    "grant_type=authorization_code" .
                    "&client_id=" . __APPID__ .
                    "&client_secret=" . __APPSECRET__ .
                    "&code=" . $meliCode .
                    "&redirect_uri=http://10.50.209.14/index.php/user/".$params['username']."/".$params['accessToken']."/appID"
                );

                core\UserManager::registerAccessToken(
                    $params['username'],
                    $response['body']->access_token,
                    $response['body']->x_ml_user_id
                );

                core\UserManager::processUserItems(
                    $meli,
                    $response['body']->x_ml_user_id,
                    $response['body']->access_token
                );

                core\UserManager::processUserSales(
                    $meli,
                    $response['body']->x_ml_user_id,
                    $response['body']->access_token
                );

                return core\General::createResponse(true, "All your data is now synced with us");
            }
        }

        return core\General::createResponse(false, 'Bad request ');
    }

}
