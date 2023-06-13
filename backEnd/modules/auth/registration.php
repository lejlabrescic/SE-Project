<?php
function registerUser($username, $email, $password, $confirmpassword, $user)
{
    // Validate the form data
    if (empty($username) || empty($email) || empty($password) || empty($confirmpassword) || empty($user)) {
        // Handle validation error
        echo json_encode(array("success" => false, "message" => "Please fill in all the fields."));
        return;
    }
    if ($password !== $confirmpassword) {
        echo json_encode(array("success" => false, "message" => "Please match the password and confirm password."));
        return;
    }

    // Perform database check
    $db = getDatabaseConnection();
    $checkStmt = $db->prepare("SELECT COUNT(*) FROM `registration` WHERE `email` = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count > 0) {
        // Email already exists
        echo json_encode(array("success" => false, "message" => "Email already exists."));
        return;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Perform database insertion
    $insertStmt = $db->prepare("INSERT INTO `registration`(`fullName`, `email`, `password`,`role`) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("ssss", $username, $email, $hashedPassword, $user);

    if ($insertStmt->execute()) {
        // Registration successful
        echo json_encode(array("success" => true, "message" => "Registration successful. Welcome, $username!"));
    } else {
        // Handle database error
        echo json_encode(array("success" => false, "message" => "Registration failed. Please try again later."));
    }

    $insertStmt->close();
    $db->close();
}
?>