<?php
// Establish database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "school";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve selected course, year, and semester from POST request
$course = $_POST['course'];
$year = $_POST['year'];
$semester = $_POST['semester'];

// Fetch course units from the database based on selected options
// Adjust the SQL query according to your database schema
$sql = "SELECT course_unit_name FROM course_units WHERE course = '$course' AND year = '$year' AND semester = '$semester'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $courseUnits = array();
    while ($row = $result->fetch_assoc()) {
        $courseUnits[] = $row['course_unit_name'];
    }
    // Send course units data as JSON response
    echo json_encode($courseUnits);
} else {
    echo json_encode(array()); // Send empty array if no course units found
}

$conn->close();
?>
