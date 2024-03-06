<?php
session_start();

// Establish database connection
$servername = "localhost";
$username = "your_username"; // Change to your database username
$password = "your_password"; // Change to your database password
$dbname = "school";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username = $_POST['username'];
$password = $_POST['password'];

// Validate credentials
$sql = "SELECT * FROM admin WHERE Username='$username' AND Password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Authentication successful
    $_SESSION["username"] = $username; // Store username in session for future use
    header("Location: admin_dashboard.php"); // Redirect to Admin's Dashboard
} else {
    // Authentication failed
    header("Location: admin_login.html?error=invalid_credentials"); // Redirect with error message
}

$conn->close();
?>
