<?php
include_once 'connection.php';
include_once '../lib/parser.php';

//------------------------------------------------------------------------------------//
/* Handling requests */
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

//------------------------------------------------------------------------------------//
/* Handling Production addition to database */
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $title = $_POST['product'];
        $price = $_POST['price'];
        $image = $_POST['image'];
        $cat = $_POST['category'];
        $page = explode("-", $image);
        $page = $page[0];

        $result = AddProduct($title, $price, $image, strtoupper($cat), strtoupper($page));
        echo json_encode($result);
    } else if ($_POST['action'] == 'fetch') {
        $page = $_POST['site'];
        $result = FetchProducts(strtoupper($page));
        echo json_encode($result);
    }
}


//------------------------------------------------------------------------------------//
/* Searching from daraz page */
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


//------------------------------------------------------------------------------------//
/* Searching from Ali Express page */
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


//------------------------------------------------------------------------------------//
/* Adding product to database */
function AddProduct($title, $price, $image, $cat, $page)
{
    $con = connection();
    try {
        $sql = "INSERT INTO products (product, price, image, category, page )VALUES ('" . $title . "', '" . $price . "', '" . $image . "', '" . $cat . "', '" . $page . "')";
        if ($con->query($sql) === true) {
            $response = array(
                'data' => 'Product Inserted to Database Successfully'
            );
            return $response;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $response = array(
                'data' => 'Product Already Available in Database!!!'
            );
            return $response;
        }
    }
    $con->close();
}

//------------------------------------------------------------------------------------//
/* Fetching product from database */
function FetchProducts($page)
{
    $con = connection();
    $product = array();
    try {
        $sql = "SELECT * FROM products WHERE page = '" . $page . "'";
        $result = $con->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $temp = array();
                $temp['Product'] = $row['product'];
                $temp['Price'] = $row['price'];
                $temp['Image'] = $row['image'];
                $temp['Category'] = $row['category'];
                $product[] = $temp;
            }
            $response = array(
                'status' => 'success',
                'data' => $product
            );
            return $response;
        } else {
            $response = array(
                'status' => 'success',
                'data' => 'No Product of ' . $page . ' available in Database',
            );
            return $response;
        }
    } catch (mysqli_sql_exception $e) {
        echo $e->getMessage();
    }
    $con->close();
}
