<?php
/**
 * Script used to create a test user
 */

define('__COUTRY__',    'MLA');
define('__APPID__',     '6283809452926869');
define('__APPSECRET__', '7jCwBNkyhBeMiydwPNGxTiNfl1Sd4CW6');

require __DIR__ . '/meli.php';

$myMeLi = new Meli(__APPID__, __APPSECRET__);

$request = new stdClass;

$request->site_id = __COUTRY__;

echo $myMeLi->getAuthUrl('http://10.50.209.14/index.php/user/TT726719/bd60f6835793b2b9199a449f6b179e11/appID');

// $newUser = $myMeLi->post('https://api.mercadolibre.com/users/test_user?access_token=APP_USR-6283809452926869-101201-3a4ac1332df1fa8125a466211252c180__G_F__-42743213');
// echo json_encode($newUser);
