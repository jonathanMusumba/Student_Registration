<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="radio"] {
            margin-right: 10px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .col {
            width: calc(50% - 10px);
            margin-right: 20px;
        }

        .col:last-child {
            margin-right: 0;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            text-decoration: none;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Student Information</h1>
        <form action="update_student_info.php" method="post">
            <!-- PHP code to fetch and populate form fields -->
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

            // Fetch student information based on registration number
            $regNumber = $_GET['regNumber']; // Assuming registration number is passed in the URL
            $sql = "SELECT * FROM Students WHERE RegNumber = '$regNumber'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of the first row (assuming registration number is unique)
                $row = $result->fetch_assoc();
                // Populate form fields with fetched data
                ?>
                <div class="row">
                    <div class="col">
                        <label for="regNumber">Registration Number:</label>
                        <input type="text" id="regNumber" name="regNumber" value="<?php echo $row['RegNumber']; ?>" readonly>
                    </div>
                    <div class="col">
                        <label for="nin">National Identification Number (NIN):</label>
                        <input type="text" id="nin" name="nin" maxlength="14" value="<?php echo $row['NIN']; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="firstName">First Name:</label>
                        <input type="text" id="firstName" name="firstName" value="<?php echo $row['First_Name']; ?>" required>
                    </div>
                    <div class="col">
                        <label for="middleName">Middle Name:</label>
                        <input type="text" id="middleName" name="middleName" value="<?php echo $row['Middle_Name']; ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="lastName">Last Name:</label>
                        <input type="text" id="lastName" name="lastName" value="<?php echo $row['Last_Name']; ?>" required>
                    </div>
                    <div class="col">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" value="<?php echo $row['Date_of_Birth']; ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label>Gender:</label>
                        <div>
                            <input type="radio" id="male" name="gender" value="M" <?php echo ($row['Gender'] == 'M') ? 'checked' : ''; ?> required>
                            <label for="male">Male</label>
                            <input type="radio" id="female" name="gender" value="F" <?php echo ($row['Gender'] == 'F') ? 'checked' : ''; ?> required>
                            <label for="female">Female</label>
                        </div>
                    </div>
                    <div class="col">
                        <label for="course">Course:</label>
                        <select id="course" name="course" onchange="populateYearAndSemester(this.value)" required>
                            <option value="">Select Course</option>
                            <!-- Populate options dynamically from the database -->
                            <!-- Dummy options for demonstration -->
                            <option value="course1" <?php echo ($row['Course'] == 'course1') ? 'selected' : ''; ?>>Course 1</option>
                            <option value="course2" <?php echo ($row['Course'] == 'course2') ? 'selected' : ''; ?>>Course 2</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="yearOfStudy">Year of Study:</label>
                        <select id="yearOfStudy" name="yearOfStudy" required>
                            <option value="">Select Year of Study</option>
                            <!-- Options will be populated dynamically based on the selected course -->
                            <option value="1" <?php echo ($row['Year_of_Study'] == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo ($row['Year_of_Study'] == '2') ? 'selected' : ''; ?>>2</option>
                            <option value="3" <?php echo ($row['Year_of_Study'] == '3') ? 'selected' : ''; ?>>3</option>
                            <option value="4" <?php echo ($row['Year_of_Study'] == '4') ? 'selected' : ''; ?>>4</option>
                        </select>
                    </div>
                    <div class="col">
                        <label for="semester">Semester:</label>
                        <select id="semester" name="semester" required>
                            <option value="">Select Semester</option>
                            <!-- Options will be populated dynamically based on the selected course -->
                            <option value="1" <?php echo ($row['Semester'] == '1') ? 'selected' : ''; ?>>1</option>
                            <option value="2" <?php echo ($row['Semester'] == '2') ? 'selected' : ''; ?>>2</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <label for="courseUnits">Course Units:</label>
                        <select id="courseUnits" name="courseUnits[]" multiple required>
                            <!-- Options will be populated dynamically based on the selected course -->
                            <option value="unit1" <?php echo (strpos($row['Course_Units'], 'unit1') !== false) ? 'selected' : ''; ?>>Unit 1</option>
                            <option value="unit2" <?php echo (strpos($row['Course_Units'], 'unit2') !== false) ? 'selected' : ''; ?>>Unit 2</option>
                            <option value="unit3" <?php echo (strpos($row['Course_Units'], 'unit3') !== false) ? 'selected' : ''; ?>>Unit 3</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="photo-preview" id="photoPreview"></div>
                        <label for="photo">Photo:</label>
                        <input type="file" id="photo" name="photo" onchange="previewPhoto(event)" accept="image/*">
                    </div>
                </div>
            <?php
            } else {
                echo "Student not found.";
            }

            // Close database connection
            $conn->close();
            ?>
            <!-- End of PHP code -->
            <div class="button-container">
                <button type="submit" class="button">Save Changes</button>
                <a href="view_student_info.php" class="button">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        // Function to populate year of study dropdown
        function populateYearAndSemester(course) {
            // Dummy data for demonstration
            var years = ["1", "2", "3", "4"];
            var semesters = ["1", "2"];

            var yearDropdown = document.getElementById("yearOfStudy");
            yearDropdown.innerHTML = "<option value=''>Select Year of Study</option>";
            for (var i = 0; i < years.length; i++) {
                yearDropdown.innerHTML += "<option value='" + years[i] + "'>" + years[i] + "</option>";
            }

            var semesterDropdown = document.getElementById("semester");
            semesterDropdown.innerHTML = "<option value=''>Select Semester</option>";
            for (var j = 0; j < semesters.length; j++) {
                semesterDropdown.innerHTML += "<option value='" + semesters[j] + "'>" + semesters[j] + "</option>";
            }

            // Additional logic can be added to populate dropdown options based on the selected course
        }

        // Function to preview photo before uploading
        function previewPhoto(event) {
            var preview = document.getElementById('photoPreview');
            var file = event.target.files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
                preview.style.backgroundImage = "url(" + reader.result + ")";
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.style.backgroundImage = null;
            }
        }
    </script>
</body>

</html>
