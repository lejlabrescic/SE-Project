<?php
require __DIR__ . '/../../models/cartModel/cartModel.php';

class uploadToCart {
    public static function UploadToCart() {
        $productId = Flight::request()->data->productId;
        $userId = Flight::request()->data->userId;
        $productName = Flight::request()->data->productName;
        $image = Flight::request()->data->image;
        $price = Flight::request()->data->price;
        $cartModel = cartModel::getInstance();
        $response = $cartModel->uploadToCartProduct($productId, $userId, $productName, $image, $price);
    }

    public static function FetchDataFromCart() {
        $cartModel = cartModel::getInstance();
        $cartData = $cartModel->fetchCardForSpecificUser();
        Flight::json($cartData);
    }

    public static function DeleteCartItem() {
        $itemId = Flight::request()->data->itemId;
        $cartModel = cartModel::getInstance();
        $response = $cartModel->deleteCartItem($itemId);
        Flight::json($response);
    }
}
?>