<?php
require __DIR__ . '/../../connection/db.php';

class cartModel {

    private static $instance;
    private $conn;

    private function __construct() {
        $this->conn = getDatabaseConnection();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new cartModel();
        }
        return self::$instance;
    }
    
    public static function uploadToCartProduct($productId, $userId, $productName, $image, $price) {
        if (empty($productId) || empty($userId) || empty($productName) || empty($image) || empty($price)) {
            return array('success' => false, 'message' => 'Please provide all required fields.');
        }

        $conn = getDatabaseConnection();
        $sql = "INSERT INTO `cart`(`productId`, `userId`, `productName`, `image`, `price`) VALUES (:productId, :userId, :productName, :image, :price)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':productId', $productId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':productName', $productName);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':price', $price);

        if ($stmt->execute()) {
            return array('success' => true, 'message' => 'Product uploaded successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to upload the product.');
        }
    }

    public static function fetchCardForSpecificUser() {
        $conn = getDatabaseConnection();
        $uId = Flight::request()->query['userId'];

        $sql = "SELECT * FROM `cart` WHERE `userId` = :userId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':userId', $uId);

        if ($stmt->execute()) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data = array();

            foreach ($result as $row) {
                $data[] = array(
                    'id' => $row['id'],
                    'pId' => $row['productName'],
                    'uId' => $row['userId'],
                    'productName' => $row['productName'],
                    'image' => $row['image'],
                    'price' => $row['price']
                );
            }

            return $data;
        } else {
            return array('success' => false, 'message' => 'Failed to fetch cart data.');
        }
    }

    public static function deleteCartItem($cartItemId) {
        $conn = getDatabaseConnection();

        $sql = "DELETE FROM `cart` WHERE `id` = :cartItemId";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':cartItemId', $cartItemId);

        if ($stmt->execute()) {
            return array('success' => true, 'message' => 'Cart item deleted successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to delete cart item.');
        }
    }
}  
  

?>
