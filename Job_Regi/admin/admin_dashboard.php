<?php

session_start();

if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in']!== true){
    header("Location: admin_login.php");
    exit();
}
$host = "localhost";
$dbname = "job_portal";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if($conn->connect_error){
    die("Connection Failed: ". $conn->connect_error);
}

//handle deletion request
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])){
    $id = intval($_POST['delete_id']);

    $delete_edu = "UPDATE education SET is_deleted = 1 WHERE application_id = ?";
    $stmt1 = $conn->prepare($delete_edu);
    $stmt1->bind_param("i",$id);
    $stmt1->execute();
    $stmt1->close();

    $delete_exp = "UPDATE experience SET is_deleted = 1 WHERE application_id = ?";
    $stmt2 = $conn->prepare($delete_exp);
    $stmt2->bind_param("i",$id);
    $stmt2->execute();
    $stmt2->close();

    $delete_application = "UPDATE applications SET is_deleted = 1 WHERE id = ?";
    $stmt3 = $conn->prepare($delete_application);
    $stmt3->bind_param("i",$id);

    if($stmt3->execute())
    {
        echo "<script>alert('Application deleted Successfully.');
                    window.location.href = 'admin_dashboard.php';
                </script>";
    }else{
        echo "<script>alert('Error deleting the application.');</script>";
    }
    $stmt3->close();
}

// Pagination Setup
$records_per_page = 6; //Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $records_per_page;

//Get total number of records
$total_records_query = "SELECT COUNT(*) AS total FROM applications WHERE is_deleted = 0";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);


$sql1 = "SELECT * FROM applications WHERE is_deleted = 0 LIMIT $offset, $records_per_page";
$result1 = $conn->query($sql1);

$sql2 = "SELECT degree FROM education WHERE is_deleted = 0 LIMIT $offset, $records_per_page";
$result2 = $conn->query($sql2);

$sql3 = "SELECT title FROM experience WHERE is_deleted = 0 LIMIT $offset, $records_per_page";
$result3 = $conn->query($sql3);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>

        /* General Body Styling */
body {
    font-family: Arial, sans-serif;
    /* background: linear-gradient(to bottom right, #283e51, #4b79a1);  */
    /* background: rgb(0, 123, 255); */
    background : white;
    margin: 20px;
    padding: 0;
    display: flex;
    flex-direction: column;
    /* align-items: center; */
    justify-content: flex-start;
    min-height: 100%;
    width: 100%;
    box-sizing: border-box;
}

label {
    color: #272727;
    font-weight: bold;
}
select {
    appearance: none;
    background-color:rgb(253, 253, 252);
    padding-right: 40px;
    cursor: pointer;
}
.export-btn{
    background-color:rgb(73, 47, 201);
    color: white;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.2s;
    border-radius: 5px;
    padding: 8px 12px;
}
.export-btn:hover{
    transform: scale(1.05);
    background-color: rgb(43, 3, 135);
}
/* Dashboard Header Styling */
h2 {
    color: #272727;
    text-align: center;
    margin-top: 20px;
    font-size: 24px;
    font-weight: bold;
}

/* Table Container */
.table-container {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 10px;
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
    overflow-x: auto;
    /* Ensures horizontal scrolling if the table overflows */
    padding: 10px;
    /* Adds padding inside the container */
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    margin: 0px;
}

th,
td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    font-size: 16px;
    color: #283e51;
}

th {
    /* background: #4b79a1; */
    background: #eb5406;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

tr:nth-child(even) {
    /* background-color: #f7fbff; */
    background-color:rgba(255, 81, 0, 0.06);
}

tr:hover {
    background-color:rgba(217, 78, 8, 0.09);
}

/* Button Styling */
button {
    background-color: red;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s, transform 0.2s;
    border-radius: 5px;
    border: none;
    padding: 8px 12px;
}

button:hover {
    transform: scale(1.05);
    background-color: rgb(211, 0, 0);
}

nav ul li a {
    color: white;
    background : #272727;
    transition: background-color 0.3s, color 0.3s;
}

nav ul li a:hover {
    background-color:rgba(235, 82, 6, 0.69);
    color: #fff;
}

/* Logout Button Styling */
.logout-btn {
    background-color: #eb5406;
    color: white;
    padding: 12px 20px;
    margin: 20px auto;
    border: none;
    border-radius: 100px;
    font-size: 18px;
    cursor: pointer;
    text-align: center;
    transition: background-color 0.4s, transform 0.2s;
}

.logout-btn:hover {
    background-color: rgb(211, 0, 0);
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    h2 {
        font-size: 20px;
    }

    th,
    td {
        font-size: 14px;
        padding: 10px;
    }

    .logout-btn {
        font-size: 16px;
        padding: 10px 15px;
    }

    .table-container {
        width: 100%;
        margin: 0 10px;
    }

    table {
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    h2 {
        font-size: 18px;
    }

    th,
    td {
        font-size: 12px;
        padding: 8px;
    }

    .logout-btn {
        font-size: 14px;
        padding: 8px 12px;
    }

    button {
        font-size: 10px;
        padding: 6px 10px;
    }
}

    </style>
</head>
<body>
    <div style= "margin: 20px 0;">
        <form method ="POST" action = "export.php">
            <label id="export_format" for="export_format">Export Format:</label>
            <select id="export_format" name="export_format" required>
                <option value= "" disabled selected>Select Format</option>
                <option value= "pdf">PDF</option>
                <option value= "excel">Excel</option>
            </select>
            <button type= "submit" class= "export-btn">Export</button>
        </form>
    </div>
<h2>Admin Dashboard</h2>
<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Position</th>
        <th>Type</th>
        <th>Degree</th>
        <th>Experience</th>
        <th>Resume</th>
        <th>Delete</th>
    </tr>
    <?php while($row1 = $result1->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row1['id']; ?></td>
            <td><?php echo $row1['full_name']; ?></td>
            <td><?php echo $row1['email']; ?></td>
            <td><?php echo $row1['phone']; ?></td>
            <td><?php echo $row1['position']; ?></td>
            <td><?php echo $row1['experience_type']; ?></td>

            <!-- Retrieve and display degrees associated with this application -->
            <td>
                <?php
                // Query for education details
                $application_id = $row1['id'];
                $education_query = "SELECT degree FROM education WHERE application_id = $application_id";
                $education_result = $conn->query($education_query);

                if ($education_result->num_rows > 0) {
                    while ($edu_row = $education_result->fetch_assoc()) {
                        echo $edu_row['degree'] . "<br>";
                    }
                } else {
                    echo "No Education Details";
                }
                ?>
            </td>

            <!-- Retrieve and display experiences associated with this application -->
            <td>
                <?php
                // Query for experience details
                $experience_query = "SELECT title FROM experience WHERE application_id = $application_id";
                $experience_result = $conn->query($experience_query);

                if ($experience_result->num_rows > 0) {
                    while ($exp_row = $experience_result->fetch_assoc()) {
                        echo $exp_row['title'] . "<br>";
                    }
                } else {
                    echo "No Experience Details";
                }
                ?>
            </td>
            <td>
                <?php if($row1['resume_path']): ?>
                    <a href="<?php echo $row1['resume_path']; ?>" target = "_blank">Resume</a>
                <?php else: ?>
                    No Resume
                <?php endif; ?>
            </td>
            <td>
                <form method = "POST" style = "display:inline;">
                    <input type = "hidden" name = "delete_id" value = "<?php echo $row1['id']; ?>">
                    <button type = "Submit" onclick = "return confirm('Are you sure you want to delete this application?');">Delete</button>
                </form>
            </td>
    <?php endwhile; ?>
</table>
        <div>
            <?php if ($total_pages>1): ?>
                <nav>
                    <ul style = "list-style-type: none; display: flex; justify-content:center; padding:0;">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li style="margin: 0 5px;">
                                <a href= "?page=<?php echo $i ?>"
                                style="text-decoration: none;
                                        padding: 5px 10px;
                                        border : 1px solid #ddd;
                                        border-radius: 100px;
                                        <?php echo $i == $page ? 'background-color:#eb5406; color: #ffff;' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>    
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>

        <form action ="logout.php" method="POST">
            <input type="Submit" value="Logout" class="logout-btn">
        </form>
</body>
</html>