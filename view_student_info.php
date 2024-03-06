<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .student-info {
            margin-bottom: 20px;
        }

        .student {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .student p {
            margin: 5px 0;
        }

        .button-container {
            text-align: center;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            margin: 0 5px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Student Information</h1>
        <div class="student-info">
            <?php
            // Include database connection or any necessary files

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

            // Retrieve student information from the database
            $sql = "SELECT * FROM Students";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='student'>";
                    echo "<p><strong>Registration Number:</strong> " . $row["RegNumber"] . "</p>";
                    echo "<p><strong>First Name:</strong> " . $row["First_Name"] . "</p>";
                    echo "<p><strong>Middle Name:</strong> " . $row["Middle_Name"] . "</p>";
                    echo "<p><strong>Last Name:</strong> " . $row["Last_Name"] . "</p>";
                    echo "<p><strong>Date of Birth:</strong> " . $row["Date_of_Birth"] . "</p>";
                    echo "<p><strong>Gender:</strong> " . $row["Gender"] . "</p>";
                    echo "<p><strong>Course:</strong> " . $row["Course"] . "</p>";
                    echo "<p><strong>Year of Study:</strong> " . $row["Year_of_Study"] . "</p>";
                    echo "<p><strong>Semester:</strong> " . $row["Semester"] . "</p>";
                    // Display course units in a table
                    echo "<p><strong>Course Units:</strong></p>";
                    echo "<table>";
                    echo "<tr><th>SN</th><th>Course Unit Name</th></tr>";
                    // Explode course units string to an array
                    $courseUnits = explode(",", $row["Course_Units"]);
                    $sn = 1;
                    foreach ($courseUnits as $unit) {
                        echo "<tr><td>$sn</td><td>$unit</td></tr>";
                        $sn++;
                    }
                    echo "</table>";
                    echo "<p><strong>National Identification Number (NIN):</strong> " . $row["NIN"] . "</p>";
                    echo "<div class='photo-container'>";
                    echo "<img src='" . $row["Photo"] . "' alt='Student Photo'>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }

            // Close database connection
            $conn->close();
            ?>
        </div>
        <div class="button-container">
            <!-- Link to cancel and go back to home page -->
            <a href="index.html" class="button">Cancel</a>
        </div>
    </div>
</body>

</html>
