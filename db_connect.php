<?php
$servername = "localhost";
$username = "root"; // Default for XAMPP
$password = ""; // Default empty password for XAMPP
$database = "grocerystore";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
} else {
    // echo "Database Connected Successfully!";
}
?>
