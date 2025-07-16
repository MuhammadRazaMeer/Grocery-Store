<?php
require 'D:\GroceryWebsite\PHPMailer-master/src/PHPMailer.php';
require 'D:\GroceryWebsite\PHPMailer-master/src/Exception.php';
require 'D:\GroceryWebsite\PHPMailer-master/src/SMTP.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer
// require 'path-to-phpmailer/PHPMailer.php'; // If manually downloaded

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];
    $address = $data['address'];
    $cart = $data['cart'];

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Use your SMTP provider
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com'; // Your email
        $mail->Password = 'your-email-password'; // Your email password (Use App Password if using Gmail)
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email Details
        $mail->setFrom('your-email@gmail.com', 'Grocery Store');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "Your Grocery Store Order Confirmation";

        // Order Details in Email
        $message = "<h3>Order Confirmation</h3>";
        $message .= "<p>Thank you, $name, for your order.</p>";
        $message .= "<p><strong>Delivery Address:</strong> $address</p>";
        $message .= "<p><strong>Phone:</strong> $phone</p>";
        $message .= "<h4>Order Summary:</h4>";
        
        $total = 0;
        $message .= "<table border='1' cellspacing='0' cellpadding='5'><tr><th>Product</th><th>Qty</th><th>Price</th></tr>";

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $total += $itemTotal;
            $message .= "<tr><td>{$item['name']}</td><td>{$item['quantity']}</td><td>\${$itemTotal}</td></tr>";
        }

        $message .= "</table>";
        $message .= "<h4>Total: $$total</h4>";

        $mail->Body = $message;

        // Send Email
        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Email sending failed: " . $mail->ErrorInfo;
    }
}
?>
