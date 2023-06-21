<?php
function registerUser($username, $email, $password, $conformpassword, $user){
    // Validate the form data
    if (empty($username) || empty($email) || empty($password) || empty($conformpassword) || empty($user)) {
        // Handle validation error
        echo json_encode(array("success" => false, "message" => "Please fill in all the fields."));
        return;
    }
    if ($password !== $conformpassword) {
        echo json_encode(array("success" => false, "message" => "Please match the password and confirm password."));
        return;
    }

    // Perform database check
    $db = getDatabaseConnection();
    $checkStmt = $db->prepare("SELECT COUNT(*) FROM `registration` WHERE `email` = :email");
    $checkStmt->bindParam(":email", $email);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();
    $checkStmt->closeCursor();

    if ($count > 0) {
        // Email already exists
        echo json_encode(array("success" => false, "message" => "Email already exists."));
        return;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform database insertion
    $insertStmt = $db->prepare("INSERT INTO `registration`(`fullName`, `email`, `password`, `role`) VALUES (:fullName, :email, :password, :role)");
    $insertStmt->bindParam(':fullName', $username);
    $insertStmt->bindParam(':email', $email);
    $insertStmt->bindParam(':password', $hashedPassword);
    $insertStmt->bindParam(':role', $user);
    if ($insertStmt->execute()) {
        // Registration successful
        echo json_encode(array("success" => true, "message" => "Registration successful. Welcome, $username!"));
    } else {
        // Handle database error
        echo json_encode(array("success" => false, "message" => "Registration failed. Please try again later."));
    }

    $insertStmt->closeCursor();
    $db = null;
}

?>