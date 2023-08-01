<?php
include_once 'connection.php';
include_once '../lib/parser.php';

/* Handling request */

if (isset($_POST['page'])) {
    if ($_POST['page'] == 'aliexp') {
        $product = $_POST['aliexp_product'];
        $result = searchAliExp($product);
        echo json_encode($result);
    } elseif ($_POST['page'] == 'daraz') {
        $product = $_POST['daraz_product'];
        $result = searchDaraz($product);
        echo json_encode($result);
    }
}




function searchDaraz($prod)
{
    $html = file_get_html('../page/daraz.html');
    $products = $html->find('div.card-jfy-item');
    $result = array();
    $isFound = false;
    $count = 0;
    foreach ($products as $product) {
        $title = $product->find('div.card-jfy-title span.title', 0);
        $price = $product->find('div.hp-mod-price-first-line span.price', 0);
        $image = $product->find('div.card-jfy-image img.image', 0)->src;
        $temp = array();
        if (str_contains(strtolower($title), strtolower($prod))) {
            $count++;
            $temp['Product'] = $title->plaintext;
            $temp['Price'] = $price->plaintext;
            $img_path = '../images/daraz-' . $prod . $count . '.jpg';
            if (!file_exists($img_path)) {
                file_put_contents('../images/daraz-' . $prod . $count . '.jpg', file_get_contents($image));
            }
            $temp['Image'] = 'daraz-' . $prod . $count . '.jpg';
            $isFound = true;
            $result[] = $temp;
        }
    }

    if (!$isFound) {
        $response = array(
            'status' => 'error',
            'data' => 'Product not Found !!!'
        );
        return $response;
    } else {
        $response = array(
            'status' => 'success',
            'data' => $result
        );
        return $response;
    }
}



function searchAliExp($prod)
{
    $html = file_get_html('../page/aliexp.html');
    $products = $html->find('div.smart-wrap');
    $result = array();
    $isFound = false;
    $count = 0;

    foreach ($products as $product) {
        $temp = array();
        $title = $product->find('div.smart-title-standard span', 0);
        $price = $product->find('div.smart-price-doubleLinesWithPrice span', 0);
        $image = $product->find('div.smart-coverImage img.smart-coverImage-standard', 0)->src;
        $temp = array();
        if (str_contains(strtolower($title), strtolower($prod))) {
            $count++;
            $temp['Product'] = $title->plaintext;
            $temp['Price'] = $price->plaintext;
            $img_path = '../images/aliexp-' . $prod . $count . '.jpg';
            if (!file_exists($img_path)) {
                file_put_contents('../images/aliexp-' . $prod . $count . '.jpg', file_get_contents($image));
            }
            $temp['Image'] = 'aliexp-' . $prod . $count . '.jpg';
            $isFound = true;
            $result[] = $temp;
        }
    }

    if (!$isFound) {
        $response = array(
            'status' => 'error',
            'data' => 'Product not Found !!!'
        );
        return $response;
    } else {
        $response = array(
            'status' => 'success',
            'data' => $result
        );
        return $response;
    }
}
