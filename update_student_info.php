<?php
// Include database connection or any necessary files

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and not empty
    if (
        isset($_POST['regNumber'], $_POST['firstName'], $_POST['lastName'])
        && !empty($_POST['regNumber']) && !empty($_POST['firstName']) && !empty($_POST['lastName'])
    ) {
        // Retrieve form data
        $regNumber = $_POST['regNumber'];
        $firstName = $_POST['firstName'];
        $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : "";
        $lastName = $_POST['lastName'];
        // Add other form fields for updating information

        // Establish database connection
        $servername = "localhost";
        $username = "your_username";
        $password = "your_password";
        $dbname = "school";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("UPDATE Students SET First_Name=?, Middle_Name=?, Last_Name=? WHERE RegNumber=?");
        $stmt->bind_param("ssss", $firstName, $middleName, $lastName, $regNumber);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            echo "Student information updated successfully";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close database connection
        $stmt->close();
        $conn->close();
    } else {
        // One or more form fields are empty
        echo "All fields are required.";
    }
} else {
    // Redirect to appropriate page if accessed directly
    header("Location: view_student_info.php");
    exit();
}
?>
