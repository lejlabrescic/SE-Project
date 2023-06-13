<?php
class WhishListModel {
    public static function uploadToWhishListProduct($productId, $userId, $productName, $image, $price) {
        if (empty($productId) || empty($userId) || empty($productName) || empty($image) || empty($price)) {
            return array('success' => false, 'message' => 'Please provide all required fields.');
        }

        $conn = getDatabaseConnection();
        $sql = "INSERT INTO `wishlist` (`productId`, `userId`, `productName`, `image`, `price`) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iisss', $productId, $userId, $productName, $image, $price);

        if ($stmt->execute()) {
            return array('success' => true, 'message' => 'Product uploaded successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to upload the product.');
        }
    }

    public static function fetchCardForSpecificUser() {
        $conn = getDatabaseConnection();
        $uId = Flight::request()->query['userId'];

        $sql = "SELECT * FROM `wishlist` WHERE `userId` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $uId);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $data = array();

            while ($row = $result->fetch_assoc()) {
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

    public static function deleteWhisListItemForDb($cartItemId) {
        $conn = getDatabaseConnection();

        $sql = "DELETE FROM `wishlist` WHERE `id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $cartItemId);

        if ($stmt->execute()) {
            return array('success' => true, 'message' => 'Cart item deleted successfully.');
        } else {
            return array('success' => false, 'message' => 'Failed to delete cart item.');
        }
    }
}
?>