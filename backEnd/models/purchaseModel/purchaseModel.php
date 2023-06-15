<?php
require __DIR__ . '/../../connection/db.php';
class purchaseModel {
    public static function purchaseProduct( $productName, $image, $price) {
        $conn = getDatabaseConnection();
        
        $sql = "INSERT INTO `purchase` ( `productName`, `image`, `price`) VALUES ( ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam('sss', $productName, $image, $price);
        
        if ($stmt->execute()) {
            return array('success' => true, 'message' => 'Purchase successful.');
        } else {
            return array('success' => false, 'message' => 'Failed to complete the purchase.');
        }
    }
}

?>