<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form fields
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize form data
    $name = htmlspecialchars(trim($name));
    $username = htmlspecialchars(trim($username));
    $password = htmlspecialchars(trim($password));

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Establish connection to the school database
    $servername = "localhost";
    $db_username = "username"; // Replace with your database username
    $db_password = "password"; // Replace with your database password
    $dbname = "school";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data into the Admin table
    $sql = "INSERT INTO admin (Name, Username, Password) VALUES ('$name', '$username', '$hashedPassword')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "Admin signed up successfully.";
    } else {
        echo "Error signing up admin: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle invalid request method
    echo "Invalid request method.";
}
?>
