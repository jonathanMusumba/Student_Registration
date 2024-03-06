// Function to populate course units based on selected course, year, and semester
function populateCourseUnits(course, year, semester) {
    // Make an AJAX request to fetch course units based on selected options
    // Replace 'fetch_course_units.php' with the URL of your PHP script to fetch course units
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var courseUnitsBody = document.getElementById("courseUnitsBody");
                courseUnitsBody.innerHTML = ""; // Clear previous content

                // Populate course units dynamically
                response.forEach(function(unit, index) {
                    var row = "<tr><td>" + (index + 1) + "</td><td>" + unit + "</td></tr>";
                    courseUnitsBody.innerHTML += row;
                });
            } else {
                console.error("Error fetching course units: " + xhr.status);
            }
        }
    };

    // Prepare data to send in the request
    var data = "course=" + course + "&year=" + year + "&semester=" + semester;

    // Send POST request to fetch course units
    xhr.open("POST", "fetch_course_units.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(data);
}