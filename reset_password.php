<?php
// Include database connection or any necessary files

// Check if email is set and not empty
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];

    // Establish connection to the school database
    $servername = "localhost";
    $db_username = "";
    $db_password = "";
    $dbname = "school";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists in the Admin table
    $sql = "SELECT * FROM Admin WHERE Email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token (for simplicity, you can use a random string)
        $token = bin2hex(random_bytes(16));

        // Store the token in the database along with the user's email
        $update_sql = "UPDATE Admin SET ResetToken='$token' WHERE Email='$email'";
        if ($conn->query($update_sql) === TRUE) {
            // Send an email to the user with a link to reset password
            // Example: sendResetPasswordEmail($email, $token);

            // For demonstration purposes, let's just echo the token
            echo "Reset token: $token";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Email does not exist in the Admin table
        echo "Email not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Email field is empty
    echo "Email field is empty.";
}
?>
