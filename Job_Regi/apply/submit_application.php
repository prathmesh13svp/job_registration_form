<?php
// Database connection details
$host = "localhost";
$dbname = "job_portal";
$username = "root";
$password = "";

// Establish a database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $full_name = $first_name . " " . $last_name;
    $email = $_POST['email'];
    $country_code = $_POST['country_code'];
    $phone = $_POST['phone'];
    $full_phone_number = $country_code . $phone;
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $experience_type = $_POST['experience_type'];
    $expected_salary = isset($_POST['expected_salary']) ? $_POST['expected_salary'] : null;
    $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
    $linkedin_profile = isset($_POST['linkedin_profile']) ? $_POST['linkedin_profile'] : null;
    $cover_letter = isset($_POST['cover_letter']) ? $_POST['cover_letter'] : null;

    // Check if the phone already exists in the database
    $phone_check_query = "SELECT * FROM applications WHERE phone = ?";
    $phone_check_stmt = $conn->prepare($phone_check_query);
    $phone_check_stmt->bind_param("s", $phone);
    $phone_check_stmt->execute();
    $phone_check_result = $phone_check_stmt->get_result();

    if ($phone_check_result->num_rows > 0) {
        // If mobile already exists, show an alert and redirect back to the form
        echo "<script>
            alert('This mobile number is already registered. Please use a different mobile number.');
            window.location.href = 'application.html';
        </script>";
        exit();
    }
    $phone_check_stmt->close();

    // Check if the email already exists in the database
    $email_check_query = "SELECT * FROM applications WHERE email = ?";
    $email_check_stmt = $conn->prepare($email_check_query);
    $email_check_stmt->bind_param("s", $email);
    $email_check_stmt->execute();
    $email_check_result = $email_check_stmt->get_result();

    if ($email_check_result->num_rows > 0) {
        // If email already exists, show an alert and redirect back to the form
        echo "<script>
            alert('This email is already registered. Please use a different email.');
            window.location.href = 'application.html';
        </script>";
        exit();
    }
    $email_check_stmt->close();

    // Handle resume upload for unique names
    $resume_dir = "../uploads/";
    $resume_path = null;

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == UPLOAD_ERR_OK) {
        // Generate a unique name for the file
        $original_name = basename($_FILES['resume']['name']);
        $file_extension = pathinfo($original_name, PATHINFO_EXTENSION); // Get the file extension
        $unique_name = pathinfo($original_name, PATHINFO_FILENAME) . "_" . time() . "." . $file_extension;
        $resume_file = $resume_dir . $unique_name;

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $resume_file)) {
            $resume_path = $resume_file;
        } else {
            echo "Error uploading resume. Proceeding without it.";
        }
    }


    // Insert main application data
    $stmt = $conn->prepare("INSERT INTO applications 
        (full_name, email, phone, gender, position, expected_salary, start_date, resume_path, linkedin_profile, cover_letter, experience_type) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "sssssdsssss",
        $full_name,
        $email,
        $full_phone_number,
        $gender,
        $position,
        $expected_salary,
        $start_date,
        $resume_path,
        $linkedin_profile,
        $cover_letter,
        $experience_type
    );

    if ($stmt->execute()) {
        // Retrieve the auto-generated application_id
        $application_id = $conn->insert_id;

        // Insert education entries
        $education_entries = [];
        foreach ($_POST['institute_name'] as $index => $institute_name) {
            $education_entries[] = [
                'institute_name' => $institute_name,
                'degree' => $_POST['degree'][$index],
                'location' => $_POST['location'][$index],
                'description' => $_POST['description'][$index],
                'from_date' => $_POST['from_date'][$index],
                'to_date' => $_POST['to_date'][$index],
                'currently_attending' => isset($_POST['currently_attending'][$index]) ? 1 : 0,
            ];
        }
        foreach ($education_entries as $entry) {
            $edu_stmt = $conn->prepare("INSERT INTO education 
                (application_id, institute_name, degree, location, description, from_date, to_date, currently_attending) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $edu_stmt->bind_param(
                "issssssi",
                $application_id,
                $entry['institute_name'],
                $entry['degree'],
                $entry['location'],
                $entry['description'],
                $entry['from_date'],
                $entry['to_date'],
                $entry['currently_attending']
            );
            $edu_stmt->execute();
            $edu_stmt->close();
        }
         
        //Handling experience entries
        $experience_entries = [];
        foreach ($_POST['experience_title'] as $index => $title) {
                $experience_entries[] = [
                    'title' => $title,
                    'company' => $_POST['experience_company'][$index],
                    'location' => $_POST['experience_location'][$index],
                    'description' => $_POST['experience_description'][$index],
                    'from_date' => $_POST['experience_from_date'][$index],
                    'to_date' => $_POST['experience_to_date'][$index],
                ];
            }
        
            // Insert experience data into the database
            foreach ($experience_entries as $entry) {
                $exp_stmt = $conn->prepare("INSERT INTO experience 
                    (application_id, title, company, location, description, from_date, to_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)");
                $exp_stmt->bind_param(
                    "issssss",
                    $application_id, // Assume this is retrieved after inserting the main application
                    $entry['title'],
                    $entry['company'],
                    $entry['location'],
                    $entry['description'],
                    $entry['from_date'],
                    $entry['to_date']
                );
                $exp_stmt->execute();
                $exp_stmt->close();
            }
        }

        // Redirect to the confirmation page
        header("Location: thank_you.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

// Close the connection
$conn->close();
?>