<?php
require __DIR__.'/../../models/productModel/productModel.php';
class ProductController {
    public static function uploadByAdmin() {
        $productName = Flight::request()->data->productName;
        $price = Flight::request()->data->price;
        $image = $_FILES['image'];
        $response = productModel::uploadProduct($productName, $image, $price);
        Flight::json($response);
    }
    public function updateProduct() {
        $productId = Flight::request()->data->id;
        $field = Flight::request()->data->field;
        $value = Flight::request()->data->value;
        $file = Flight::request()->files->file;
    
        $model = new ProductModel();
        $result = $model->updateProduct($productId, $field, $value, $file);
    
        if ($result['success']) {
            Flight::json(array("success" => true, "message" => "Product field updated successfully."));
        } else {
            Flight::json(array("success" => false, "message" => $result['message']));
        }
    }
    public function deleteProduct($id) {
        $model = new ProductModel();
        $result = $model->deleteProduct($id);

        if ($result) {
            Flight::json(array("success" => true, "message" => "Product deleted successfully."));
        } else {
            Flight::json(array("success" => false, "message" => "Failed to delete product."));
        }
    }
    

}
