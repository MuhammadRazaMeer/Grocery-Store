<?php
include 'db_connect.php';
session_start();

// Database Connection
$conn = new mysqli('localhost', 'root', '', 'grocerystore');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Check if fields are empty
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password.'); window.location.href='login.html';</script>";
        exit;
    }

    // Prepare and execute query
    $query = "SELECT * FROM newusers WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['login_message'] = "You are successfully logged in!";

            // Redirect to homepage
            header("Location: index.html");
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href='login.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.location.href='login.html';</script>";
    }

    // Cleanup
    $stmt->close();
    $conn->close();
}
?>

