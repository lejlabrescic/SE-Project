<?php
require 'vendor/autoload.php'; // Include PHPMailer library
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($name, $email, $subject, $message) {
  // Instantiate PHPMailer
  $mail = new PHPMailer(true);

  try {
    // SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'lbrescic@gmail.com'; // Replace with your Gmail email address
    $mail->Password = 'Leyscofield22'; // Replace with your Gmail password

    // Sender and recipient details
    $mail->setFrom('lbrescic@gmail.com'); // Replace with your Gmail email address
    $mail->addAddress('lejla.brescic@stu.ibu.edu.ba'); // Replace with the recipient's email address

    // Email content
    $mail->Subject = $subject;
    $mail->Body = "Name: $name\nEmail: $email\nMessage: $message";

    // Send the email
    $mail->send();
    echo 'Email sent successfully';
  } catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
  }
}

// Usage example
$fullName = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

sendEmail($name, $email, $subject, $message);
