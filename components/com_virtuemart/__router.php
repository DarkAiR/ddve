<?php

defined('_JEXEC') or die('Restricted access');

define('PAGE_SHOP_BROWSE', 'category');
define('PAGE_SHOP_MANUFACTURER', 'manufacturer');
define('PAGE_SHOP_FEED', 'feed');
define('PAGE_PRODUCT_DETAILS', 'details');
define('PAGE_PRODUCT_ENQUIRY', 'enquiry');
define('PAGE_CHECKOUT_INDEX', 'checkout');
define('PAGE_ADVANCE_SEARCH', 'search');

function virtuemartBuildRoute(&$query)
{

    $page = '';
    $segments = array();

    if (isset($query['page'])) {
        $page = $query['page'];
        unset($query['page']);
    }

    if (isset($query['flypage'])) {
        unset($query['flypage']);
    }


    switch ($page) {

            /* Case for shop browse/catgory page */
        case 'shop.browse';

            if (isset($query['category_id'])) {
                $segments[] = PAGE_SHOP_BROWSE;
                $segments[] = $query['category_id'];
                $category_alias = getCategoryTitle($query['category_id']);
                //$segments[] = $category_alias;
                unset($query['category_id']);

            } else // Страница Товары производителея...

                if (isset($query['manufacturer_id'])) {
                    $segments[] = PAGE_SHOP_MANUFACTURER;
                    $segments[] = $query['manufacturer_id'];
                    $manufacturer_alias = getmanufacturerName($query['manufacturer_id']);
                    //$segments[] = $manufacturer_alias;
                    //var_dump($manufacturer_alias);
                    unset($query['manufacturer_id']);
                    // END Страница Товары производителея...
                    
                } else {
                    $segments[] = "products";
                    unset($query['category']);
                }
                break;
            /*End shop browse/catgory page*/

            /* Case for shop rss feed page */
        case 'shop.feed';

            $segments[] = PAGE_SHOP_FEED;

            if (isset($query['category_id'])) {
                $segments[] = $query['category_id'];
                $category_alias = getCategoryTitle($query['category_id']);
                //$segments[] = $category_alias;
                unset($query['category_id']);
            }
            break;
            /*End shop browse/catgory page*/


            /* Case for product details page */
        case 'shop.product_details';
            $segments[] = PAGE_PRODUCT_DETAILS;
            $product_id_exists = false;
            if (isset($query['product_id'])) {
                $segments[] = $query['product_id'];
                $product_id_exists = true;
                $pid = $query['product_id'];
                unset($query['product_id']);
            }
            if (isset($query['category_id'])) {
                $segments[] = $query['category_id'];
                $category_alias = getCategoryTitle($query['category_id']);
                //$segments[] = $category_alias;
                unset($query['category_id']);
            }
            if ($product_id_exists) {
                $product_alias = getProductTitle($pid);
                //$segments[] = $product_alias;
            }
            // Удаление в конце ссылок мусора ?manufacturer_id=XX
            unset($query['manufacturer_id']);
            break;
            /*End shop browse/catgory page*/

            /*Case for ASK A QUESTION ABOUT THIS PRODUCT PAGE*/
        case 'shop.ask';
            $segments[] = PAGE_PRODUCT_ENQUIRY;

            if (isset($query['category_id'])) {
                $segments[] = $query['category_id'];
                unset($query['category_id']);
            }

            if (isset($query['product_id'])) {
                $segments[] = $query['product_id'];
                $product_id_exists = true;
                $pid = $query['product_id'];
                unset($query['product_id']);
            }

            if ($product_id_exists) {
                $product_alias = getProductTitle($pid);
                //$segments[] = $product_alias;
            }

            break;
            /*End*/

            /*
            Checkout Index page
            */
        case 'checkout.index';
            $segments[] = PAGE_CHECKOUT_INDEX;

            if (isset($query['ssl_redirect'])) {
                $segments[] = "ssl_redirect";
                unset($query['ssl_redirect']);
            }

            if (isset($query['redirected'])) {
                $segments[] = "redirected";
                unset($query['redirected']);
            }

            break;
            /** End of checkout index page */


        case 'account.billing';
            $segments[] = "account-billing";
            if (isset($query['next_page'])) {
                $segments[] = "checkout";
                unset($query['next_page']);
            }
            break;

        case 'account.shipto';
            $segments[] = "account-shipto";
            if (isset($query['next_page'])) {
                $segments[] = "checkout";
                unset($query['next_page']);
            }
            break;

        case 'account.shipping';
            $segments[] = "account-shipping";
            if (isset($query['next_page'])) {
                $segments[] = "checkout";
                unset($query['next_page']);
            }
            break;

        case 'shop.registration';
            $segments[] = "user-registration";
            break;

        case 'shop.recommend';
            $segments[] = "recommend";

            if (isset($query['tmpl'])) {
                $segments[] = $query['tmpl'];
                unset($query['tmpl']);
            }

            if (isset($query['pop'])) {
                $segments[] = $query['pop'];
                unset($query['pop']);
            }

            if (isset($query['product_id'])) {
                $segments[] = $query['product_id'];
                $product_alias = getProductTitle($query['product_id']);
                $segments[] = $product_alias;
                unset($query['product_id']);
            }
            break;

        case 'shop.tos';
            $segments[] = "terms-of-service";
            break;

        case 'shop.cart';
            $segments[] = "cart";
            break;

        case 'account.index';
            $segments[] = "account";
            break;

        case 'account.order_details';
            $segments[] = "order-details";
            if (isset($query['order_id'])) {
                $segments[] = $query['order_id'];
                unset($query['order_id']);
            }
            break;

        case 'shop.waiting_list';
            $segments[] = "notify";
            if (isset($query['product_id'])) {
                $segments[] = $query['product_id'];
                $product_id_exists = true;
                $pid = $query['product_id'];
                unset($query['product_id']);
            }

            if ($product_id_exists) {
                $product_alias = getProductTitle($pid);
                $segments[] = $product_alias;
            }
            break;

        case 'shop.search';
            $segments[] = PAGE_ADVANCE_SEARCH;
            break;

        case 'store.index';
            $segments[] = 'administration';
            break;
    }
    //var_dump($segments);
    return $segments;
}
/*End of the function*/


function virtuemartParseRoute($segments)
{
    $vars = array();
    $firstSegment = $segments[0];
    switch ($firstSegment) {

        case PAGE_SHOP_BROWSE:
            $vars['page'] = "shop.browse";
            if (isset($segments[1])) {
                $vars['category_id'] = $segments[1];
            }
            break;

        case PAGE_SHOP_MANUFACTURER:
            $vars['page'] = "shop.browse";
            if (isset($segments[1])) {
                $vars['manufacturer_id'] = $segments[1];
            }
            break;

            /*This is for all products page*/
        case 'products':
            $vars['page'] = "shop.browse";
            $vars['category'] = "";
            break;


        case PAGE_SHOP_FEED:
            $vars['page'] = "shop.feed";
            if (isset($segments[1])) {
                $vars['category_id'] = $segments[1];
            }

            break;

        case PAGE_PRODUCT_DETAILS:
            $vars['page'] = "shop.product_details";

            if (isset($segments[1])) {
                $vars['product_id'] = $segments[1];
            }

            if (isset($segments[2])) {
                $vars['category_id'] = $segments[2];
            }
            break;

        case PAGE_PRODUCT_ENQUIRY:
            $vars['page'] = "shop.ask";
            $vars['category_id'] = $segments[1];
            $vars['product_id'] = $segments[2];
            break;

        case PAGE_CHECKOUT_INDEX:
            $vars['page'] = "checkout.index";

            if (isset($segments[1]) && ($segments[1] == "ssl_redirect")) {
                $vars['ssl_redirect'] = 1;

            }

            if (isset($segments[2]) && ($segments[2] == "redirected")) {
                $vars['redirected'] = 1;
            }
            break;

        case 'account:billing':
            $vars['page'] = "account.billing";
            if (isset($segments[1])) {
                $vars['next_page'] = "checkout.index";
            }
            break;

        case 'account:shipto':
            $vars['page'] = "account.shipto";
            if ($segments[1]) {
                $vars['next_page'] = "checkout.index";
            }
            break;

        case 'account:shipping':
            $vars['page'] = "account.shipping";
            if ($segments[1]) {
                $vars['next_page'] = "checkout.index";
            }
            break;

        case 'recommend';
            $vars['page'] = "shop.recommend";
            $vars['pop'] = 1;
            $vars['product_id'] = $segments[3];
            $vars['tmpl'] = "component";
            break;

        case 'user:registration';
            $vars['page'] = "shop.registration";
            break;

        case 'account':
            $vars['page'] = "account.index";
            break;

        case 'cart':
            $vars['page'] = "shop.cart";
            break;

        case 'order:details':
            $vars['page'] = "account.order_details";
            $vars['order_id'] = $segments[1];
            break;

        case 'temrs:of:service':
            $vars['page'] = "shop.tos";
            break;

        case 'notify':
            $vars['page'] = "shop.waiting_list";
            $vars['product_id'] = $segments[1];
            break;

        case PAGE_ADVANCE_SEARCH:
            $vars['page'] = "shop.search";

            break;

        case 'administration':
            $vars['page'] = "store.index";
            $vars['pshop_mode'] = "admin";

            break;

    }
    return $vars;
}

/*
This function returns category/subcatgory alias string
*/

function getCategoryTitle($id)
{
    $db = &JFactory::getDBO();

    $query = "
			SELECT t1.category_child_id AS lev1, t2.category_child_id as lev2, t3.category_child_id as lev3
			FROM  #__vm_category_xref AS t1
			LEFT JOIN #__vm_category_xref AS t2 ON t2.category_child_id = t1.category_parent_id
			LEFT JOIN #__vm_category_xref AS t3 ON t3.category_child_id = t2.category_parent_id
			WHERE t1.category_child_id= " . $id;

    $db->setQuery($query);
    $nestedCategoryIds = $db->loadObject();
    if ($nestedCategoryIds == "")
        return;

    $catIdsArr = array();

    if ($nestedCategoryIds->lev3) {
        $catIdsArr[] = $nestedCategoryIds->lev3;
    }

    if ($nestedCategoryIds->lev2) {
        $catIdsArr[] = $nestedCategoryIds->lev2;
    }

    if ($nestedCategoryIds->lev1) {
        $catIdsArr[] = $nestedCategoryIds->lev1;
    }

    $catIdsStr = implode(',', $catIdsArr);

    $query = "SELECT GROUP_CONCAT( category_name
			SEPARATOR  '/' )
			FROM #__vm_category
			WHERE category_id IN (" . $catIdsStr . ")";


    $db->setQuery($query);
    $category_alias = $db->loadResult();
    //$category_alias = strtolower($category_alias);

    //Remove following characters
    $special_chars = array('!', '@', '#', '$', '%', '*', '(', ')');
    foreach ($special_chars as $char) {
        $category_alias = str_replace($char, '', $category_alias);
    }

    $category_alias = str_replace(' ', '-', $category_alias);
    $category_alias = vm_translate(str_replace('  ', '-', $category_alias));
    return $category_alias;
}

function getProductTitle($id)
{
    $db = &JFactory::getDBO();
    // gets category name
    $query = 'SELECT product_name FROM #__vm_product  ' . ' WHERE product_id = ' . (int)
        $id;

    $db->setQuery($query);
    // gets category name of item
    $product_name = $db->loadResult();
    //$product_name = mb_strtolower($product_name);

    //Remove following characters
    $special_chars = array('!', '@', '#', '$', '%', '*', '(', ')');
    foreach ($special_chars as $char) {
        $product_name = str_replace($char, '', $product_name);
    }

    $product_name = str_replace(' ', '-', $product_name);
    $product_name = vm_translate(str_replace('  ', '-', $product_name));
    return $product_name;
}


function getmanufacturerName($id)
{
    $db = &JFactory::getDBO();
    // gets manufacturer name
    $query = 'SELECT mf_name FROM #__vm_manufacturer WHERE manufacturer_id = ' . (int)
        $id;
    $db->setQuery($query);
    // gets manufacturer name of item
    $mf_name = $db->loadResult();
    // $mf_name = strtolower($mf_name);

    //Remove following characters
    $special_chars = array('!', '@', '#', '$', '%', '*', '(', ')');
    foreach ($special_chars as $char) {
        $mf_name = str_replace($char, '', $mf_name);
    }

    $mf_name = str_replace(' ', '-', $mf_name);
    $mf_name = vm_translate(str_replace('  ', '-', $mf_name));
    return $mf_name;
}

function vm_translate($title)
{
    $tbl = array('а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' =>
        'e', 'ж' => 'g', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' =>
        'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' =>
        'u', 'ф' => 'f', 'ы' => 'i', 'э' => 'e', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' =>
        'G', 'Д' => 'D', 'Е' => 'E', 'Ж' => 'G', 'З' => 'Z', 'И' => 'I', 'Й' => 'Y', 'К' =>
        'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' =>
        'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Ы' => 'I', 'Э' => 'E', 'ё' => "yo",
        'х' => "h", 'ц' => "ts", 'ч' => "ch", 'ш' => "sh", 'щ' => "shch", 'ъ' => "", 'ь' =>
        "", 'ю' => "yu", 'я' => "ya", 'Ё' => "YO", 'Х' => "H", 'Ц' => "TS", 'Ч' => "CH",
        'Ш' => "SH", 'Щ' => "SHCH", 'Ъ' => "", 'Ь' => "", 'Ю' => "YU", 'Я' => "YA", ' ' =>
        "-", '(' => '', ')' => '', ',' => '', '.' => '');

    $translate = mb_strtolower(strtr($title, $tbl));
    return $translate;
}

?>