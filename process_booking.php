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

$mail = new PHPMailer(true);

$email = isset($_POST['email']) ? $_POST['email'] : ''; 
$persons = isset($_POST['persons']) ? $_POST['persons'] : '';
$places = isset($_POST['places']) ? $_POST['places'] : '';
$days = isset($_POST['days']) ? $_POST['days'] : '';

try {

    $stmt = $conn->prepare("INSERT INTO bookings (email, persons, places, days) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $email, $persons, $places, $days);

    if ($stmt->execute()) {
        
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'adipudinagendrababu@gmail.com'; 
        $mail->Password = 'cuwj vmip kztf duno'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('adipudinagendrababu@gmail.com', 'Naga');
        $mail->addAddress($email); 

        $mail->isHTML(true);
        $mail->Subject = 'Booking Confirmation';
        $mail->Body = "Dear Customer,<br><br>Thank you for your booking!<br><br>" .
                      "Booking Details:<br>" .
                      "Email: $email<br>" .
                      "Number of Persons: $persons<br>" .
                      "Selected Place: $places<br>" .
                      "Number of Days: $days<br><br>" .
                      "We look forward to serving you.<br><br>Best regards,<br>Your Travel Company";

        $mail->send();
        header("Location: booking_sucessfull.html");
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error sending email: {$mail->ErrorInfo}";
}

$conn->close();
?>