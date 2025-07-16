<?php
include 'db_connect.php';

// Get JSON input from JavaScript fetch()
$data = json_decode(file_get_contents("php://input"), true);

// Check if JSON was received
if (!$data) {
    echo "No JSON data received!";
    exit;
}

// Extract values from decoded JSON
$fullName = $data['name'];
$email = $data['email'];
$phone = $data['phone'];
$address = $data['address'];

// Connect to database
$conn = new mysqli('localhost', 'root', '', 'grocerystore');
if($conn->connect_error){
    die('Connection Failed: ' . $conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO orders (fullName, email, phone, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullName, $email, $phone, $address);
    $stmt->execute();
    echo "Order placed successfully!";
    $stmt->close();
    $conn->close();
}
?>
