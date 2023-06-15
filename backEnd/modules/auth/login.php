<?php
require './connection/db.php';

function loginUser($email, $password) {
    // Validate the form data
    if (empty($email) || empty($password)) {
        // Handle validation error
        echo json_encode(array("success" => false, "message" => "Please enter your email and password."));
        return;
    }

    // Check if the user exists in the database
    $db = getDatabaseConnection();
    $stmt = $db->prepare("SELECT * FROM `registration` WHERE `email` = :email");
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $hashedPassword = $result['password'];
    $rowCount = $stmt->rowCount();
    if ($rowCount === 1) {
        if (password_verify($password, $hashedPassword)) {
            // Password is correct, login successful
            $_SESSION['user_id'] = $result['id']; // Store user ID in the session variable

            // Return the user ID in the response
            echo json_encode(array("success" => true, "message" => "Login successful. Welcome, " . $result['fullName'] . "!", "userId" => $result['id'], "role" => $result['role']));
        } else {
            // Password is incorrect
            echo json_encode(array("success" => false, "message" => "Incorrect password. Please try again."));
        }
    } else {
        // User not found
        echo json_encode(array("success" => false, "message" => "User not found. Please check your email."));
    }

    $stmt->closeCursor();

}
