<?php
include 'db_connect.php';
// Start the session
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'grocerystore'); // Adjust the database name if needed

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and get form data
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
    // Check if all fields are filled
    if (empty($fullname) || empty($email) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.location.href='signup.html';</script>";
        exit;
    }

    // Check if the email already exists in the database
    $query = "SELECT * FROM newusers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If email already exists, show error message
        echo "<script>alert('This email is already registered. Please log in.'); window.location.href='login.html';</script>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $query = "INSERT INTO newusers (fullname, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $fullname, $email, $hashed_password);
        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            echo "<script>alert('Account created successfully! Please log in.'); window.location.href='login.html';</script>";
        } else {
            // Error occurred while inserting
            echo "<script>alert('There was an error. Please try again later.'); window.location.href='signup.html';</script>";
        }
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
