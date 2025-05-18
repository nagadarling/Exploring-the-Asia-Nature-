<?php
require 'vendor/autoload.php'; 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "travel"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("INSERT INTO contacts (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$subject = isset($_POST['subject']) ? $_POST['subject'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

try {
    
    if ($stmt->execute()) {
        
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sktaheer45@gmail.com'; 
        $mail->Password = 'cuwj vmip kztf duno'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        
        $mail->setFrom('sktaheer45@gmail.com', 'Your Name');
        $mail->addAddress($email); 

        
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Submission Confirmation';
        $mail->Body = "Dear $name,<br><br>Thank you for contacting us!<br><br>" .
                      "Your message has been received. Here are the details:<br>" .
                      "Name: $name<br>" .
                      "Email: $email<br>" .
                      "Phone: $phone<br>" .
                      "Subject: $subject<br>" .
                      "Message: $message<br><br>" .
                      "We will get back to you shortly.<br><br>Best regards,<br>Your Travel Company";

        $mail->send();

        
        header("Location: booking_sucessfull.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
}

$stmt->close();

$conn->close();
?>