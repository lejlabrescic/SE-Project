<?php
require __DIR__ . '/../../connection/db.php';
require_once 'Product.php';
require_once 'ProductBuilder.php';

class ProductModel {
    public static function uploadProduct($productName, $image, $price) {
        if (empty($productName) || empty($image['name']) || empty($price)) {
            return array('success' => false, 'message' => 'Please provide all required fields.');
        }
        $allowedExtensions = array('jpeg', 'jpg', 'png', 'gif', 'svg');
        $fileExtension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        if (!in_array($fileExtension, $allowedExtensions)) {
            return array('success' => false, 'message' => 'Invalid file type. Only JPEG, JPG, PNG, GIF, and SVG files are allowed.');
        }
        $uploadPath = __DIR__ .'./../../../FrontEnd/assets/upload/';
        $fileName = uniqid() . '.' . $fileExtension;
        $destination = $uploadPath . $fileName;
        if (!move_uploaded_file($image['tmp_name'], $destination)) {
            return array('success' => false, 'message' => 'Failed to upload the file.');
        }

        $builder = new ProductBuilder();
        $product = $builder
            ->setName($productName)
            ->setPrice($price)
            ->setImage($fileName)
            ->build();

        $conn = getDatabaseConnection();
        try {
            $name = $product->getName();
            $image = $product->getImage();
            $price = $product->getPrice();

            $sql = "INSERT INTO `productdetails`(`productName`, `image`, `price`) VALUES (:productName, :image, :price)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':productName', $name);
            $stmt->bindParam(':image', $image); 
            $stmt->bindParam(':price', $price); 
            if ($stmt->execute()) {
                return array('success' => true, 'message' => 'Product uploaded successfully.');
            } else {
                return array('success' => false, 'message' => 'Failed to upload the product.');
            }
        } catch (Exception $e) {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    public function updateProduct($productId, $field, $value, $file = null)
    {
        $conn = getDatabaseConnection();
    
        try {
            if ($field === 'image') {
                // Handle image upload
                if ($file) {
                    $targetDir =  __DIR__ .'./../../../FrontEnd/assets/upload/';
                    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $filename = 'image_' . date('YmdHis') . '.' . $extension;
                    $targetFile = $targetDir . $filename;
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
                    // Check if the file is a valid image
                    $check = getimagesize($file['tmp_name']);
                    if ($check !== false) {
                        $uploadOk = 1;
                    } else {
                        return array('success' => false, 'message' => 'Error: Invalid image file.');
                    }
    
                    // Check if the file already exists
                    if (file_exists($targetFile)) {
                        return array('success' => false, 'message' => 'Error: File already exists.');
                    }
    
                    // Allow only specific file formats
                    if ($imageFileType != 'jpg' && $imageFileType != 'jpeg' && $imageFileType != 'png' && $imageFileType != 'gif') {
                        return array('success' => false, 'message' => 'Error: Only JPG, JPEG, PNG, and GIF files are allowed.');
                    }
    
                    // Move the uploaded file to the target directory
                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        // File uploaded successfully, update the image field in the database
                        $sql = "UPDATE `productdetails` SET `$field` = :field WHERE `id` = :id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':field', $filename);
                        $stmt->bindParam(':id', $productId); 
                        $stmt->execute();

                        $rowCount = $stmt->rowCount();
                        
                        if ($rowCount > 0) {    
                        
                            // Update successful
                            return array('success' => true, 'message' => 'Product image updated successfully.');
                        } else {
                            // No rows affected, update failed
                            return array('success' => false, 'message' => 'Failed to update product image.');
                        }
                    } else {
                        return array('success' => false, 'message' => 'Error: Failed to upload the file.');
                    }
                }
            } else {
                // Handle other fields
                $sql = "UPDATE `productdetails` SET `$field` = :value WHERE `id` = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":value", $value);
                $stmt->bindParam(':id', $id); 
                $stmt->execute();
                $rowCount = $stmt->rowCount();
                        
                if ($rowCount > 0) {    
                        
                    // Update successful
                    return array('success' => true, 'message' => 'Product field updated successfully.');
                } else {
                    // No rows affected, update failed
                    return array('success' => false, 'message' => 'Failed to update product field.');
                }
            }
        } catch (Exception $e) {
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }
    public function deleteProduct($id) {
        $conn = getDatabaseConnection();
        $stmt = $conn->prepare("DELETE FROM `productdetails` WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
                        
        return $stmt->$rowCount > 0;
    }
    
    

}

?>