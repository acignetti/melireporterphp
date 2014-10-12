<?php
namespace Reporter\modules\core;

/**
 * Script that populates the database with current ML's information according
 * to which country is used for this instance
 */

require __DIR__ . '/../Main.php';

\Reporter\modules\Main::setUpEnvironment();

define('__COUTRY__',    'MLA');
define('__APPID__',     '6283809452926869');
define('__APPSECRET__', '7jCwBNkyhBeMiydwPNGxTiNfl1Sd4CW6');

require __DIR__ . '/meli.php';

$finalCategories = array();

$myMeLi = new \Meli(__APPID__, __APPSECRET__);

function processChildrens($meli, $father) {
    $childrens = $meli->get('https://api.mercadolibre.com/categories/' . $father->getMLID())['body'];

    echo $father->getID();

    foreach ($childrens->children_categories as $children) {
        $currentChildren = new \Reporter\modules\database\vo\CategoryVO;

        $currentChildren->setName($children->name);
        $currentChildren->setMLID($children->id);
        $currentChildren->setFather($father->getID());

        \Reporter\modules\database\dao\CategoryDAO::save($currentChildren);

        processChildrens($meli, $currentChildren);
    }
}

$categories = $myMeLi->get('https://api.mercadolibre.com/sites/' . __COUTRY__ . '/categories')['body'];
$payments   = $myMeLi->get('https://api.mercadolibre.com/sites/' . __COUTRY__ . '/payment_methods')['body'];

foreach ($categories as $father) {
    $currentCategory = new \Reporter\modules\database\vo\CategoryVO;

    $currentCategory->setName($father->name);
    $currentCategory->setMLID($father->id);

    \Reporter\modules\database\dao\CategoryDAO::save($currentCategory);

    processChildrens($myMeLi, $currentCategory);
}

foreach ($payments as $current) {
    $payment = new \Reporter\modules\database\vo\PaymentTypeVO;

    $payment->setName($current->id);
    $payment->setDescription($current->name);
    $payment->setCategory($current->type);

    \Reporter\modules\database\dao\PaymentTypeDAO::save($payment);
}

echo "Listo";
