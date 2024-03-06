<?php
// Include database connection or any necessary files

// Function to check if a student with the given registration number already exists
function isStudentExists($conn, $regNumber)
{
    $stmt = $conn->prepare("SELECT ID FROM Students WHERE RegNumber = ?");
    $stmt->bind_param("s", $regNumber);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}

// Check if form fields are set and not empty
if (
    isset($_POST['regNumber'], $_POST['firstName'], $_POST['lastName'], $_POST['dob'], $_POST['gender'], 
    $_POST['course'], $_POST['yearOfStudy'], $_POST['semester'], $_POST['courseUnits'], $_POST['nin'])
    && !empty($_POST['regNumber']) && !empty($_POST['firstName']) && !empty($_POST['lastName']) 
    && !empty($_POST['dob']) && !empty($_POST['gender']) && !empty($_POST['course']) 
    && !empty($_POST['yearOfStudy']) && !empty($_POST['semester']) && !empty($_POST['courseUnits']) 
    && !empty($_POST['nin'])
) {
    // Retrieve form data
    $regNumber = $_POST['regNumber'];
    $firstName = $_POST['firstName'];
    $middleName = isset($_POST['middleName']) ? $_POST['middleName'] : "";
    $lastName = $_POST['lastName'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $course = $_POST['course'];
    $yearOfStudy = $_POST['yearOfStudy'];
    $semester = $_POST['semester'];
    $courseUnits = $_POST['courseUnits'];
    $nin = $_POST['nin'];

    // Upload photo
    $photo = $_FILES['photo'];
    $photoName = $photo['name'];
    $photoTmpName = $photo['tmp_name'];
    $photoError = $photo['error'];

    if ($photoError === 0) {
        $photoDestination = 'uploads/' . $photoName;
        move_uploaded_file($photoTmpName, $photoDestination);
    } else {
        echo "Error uploading photo.";
        exit();
    }

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

    // Check if the student already exists in the database
    if (isStudentExists($conn, $regNumber)) {
        echo "Student with registration number $regNumber already exists.";
        // Handle edit and resubmit option
        // Retrieve existing student data and populate the form for editing
    } else {
        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO Students (RegNumber, First_Name, Middle_Name, Last_Name, Date_of_Birth, Gender, Course, Year_of_Study, Semester, Course_Units, Photo, NIN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssiisss", $regNumber, $firstName, $middleName, $lastName, $dob, $gender, $course, $yearOfStudy, $semester, $courseUnits, $photoDestination, $nin);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            echo "New record created successfully";
            // Display summary of all information given in the table
            // You can redirect the user to a summary page or display it here
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close database connection
        $stmt->close();
    }
    $conn->close();
} else {
    // One or more form fields are empty
    echo "All fields are required.";
}
?>
