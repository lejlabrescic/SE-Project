<?php
require 'vendor/autoload.php';
require './modules/auth/registration.php';
require './modules/auth/login.php';
require './controller/productController/productController.php';
require './controller/addTocart/addToCartController.php';
require './controller/whsilistController/WhishListController.php';
require './models/purchaseModel/purchaseModel.php';
session_start();
Flight::route('/',function(){
    echo "hello to flight php";
});
Flight::route('POST /register', function(){
    $username = Flight::request()->data['username'];
    $email = Flight::request()->data['email'];
    $password = Flight::request()->data['password'];
    $conformpassword = Flight::request()->data['conformpassword'];
    $user = Flight::request()->data['user'];
    registerUser($username, $email, $password,$conformpassword,$user);
});

Flight::route('POST /login',function(){
    $email = Flight::request()->data['email'];
    $password = Flight::request()->data['password'];
    loginUser($email,$password);
});

Flight::route('GET /products', function() {
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM `productdetails`");
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
    Flight::json($products);
});
Flight::route('POST /updateProduct', function(){
    $controller = new ProductController();
    $controller->updateProduct();
});
Flight::route('DELETE /products/@id', function($id){
    $controller = new ProductController();
    $controller->deleteProduct($id);
});

Flight::route('POST /product/upload', function() {
    ProductController::uploadByAdmin();
});
Flight::route('POST /product/chart/upload',function(){
    uploadToCart::UploadTocart();
});
Flight::route('GET /fetchCartData', function() {
    uploadToCart::fetchDataFromCart();
});
Flight::route('POST /deleteCartItem', function() {
    uploadToCart::deleteCartItem();
});


Flight::route('POST /product/chart/upload/wishlist',function(){
    uploadToWhislist::UploadToWhislistItem();
});
Flight::route('GET /fetchwishlistData', function() {
    uploadToWhislist::fetchDataFromwislist();
});
Flight::route('POST /deletewhislistItem', function() {
    uploadToWhislist::deleteWhislistItem();
});


Flight::route('POST /purchase', function() {
    $productName = Flight::request()->data->productName;
    $image = Flight::request()->data->image;
    $price = Flight::request()->data->price;

    $response = purchaseModel::purchaseProduct($productName, $image, $price);
    Flight::json($response);
});

Flight::route('/logout', function(){
    if (isset($_SESSION['user_id'])) {
        unset($_SESSION['user_id']);
    }
});
Flight::route('/checkSession', function(){
    $response = array();
    if (isset($_SESSION['user_id'])) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
    echo json_encode($response);
});


Flight::start();