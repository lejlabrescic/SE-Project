<?php
require __DIR__ . '/../../models/whislistItemModel/WhishListModel.php';

class uploadToWhislist {
    public static function UploadToWhislistItem() {
        $productId = Flight::request()->data->productId;
        $userId = Flight::request()->data->userId;
        $productName = Flight::request()->data->productName;
        $image = Flight::request()->data->image;
        $price = Flight::request()->data->price;
        $response = WhishListModel::uploadToWhishListProduct($productId, $userId, $productName, $image, $price);
        Flight::json($response);
    }

    public static function FetchDataFromWhislist() {
        $cartData = WhishListModel::fetchCardForSpecificUser();
        Flight::json($cartData);
    }

    public static function DeleteWhislistItem() {
        $itemId = Flight::request()->data->itemId;
        $response = WhishListModel::deleteWhisListItemForDb($itemId);
        Flight::json($response);
    }
}

?>