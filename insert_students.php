<?php
// Establish a connection to the database
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "school";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sample student data (you can retrieve this from a form submission)
$regNumber = $_POST['regNumber'];
$firstName = $_POST['firstName'];
$middleName = $_POST['middleName'];
$lastName = $_POST['lastName'];
$dateOfBirth = $_POST['dob'];
$gender = $_POST['gender'];
$course = $_POST['course'];
$yearOfStudy = $_POST['yearOfStudy'];
$semester = $_POST['semester'];
$courseUnits = $_POST['courseUnits'];
$photo = $_FILES['photo']['name']; // Assuming the file is uploaded and stored on the server
$nin = $_POST['nin'];

// Prepare and execute SQL statement to insert data into the Students table
$sql = "INSERT INTO Students (RegNumber, First_Name, Middle_Name, Last_Name, Date_of_Birth, Gender, Course, Year_of_Study, Semester, Course_Units, Photo, NIN)
        VALUES ('$regNumber', '$firstName', '$middleName', '$lastName', '$dateOfBirth', '$gender', '$course', '$yearOfStudy', '$semester', '$courseUnits', '$photo', '$nin')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
