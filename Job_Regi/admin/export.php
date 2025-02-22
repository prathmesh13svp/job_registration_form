<?php
$host = "localhost";
$dbname = "job_portal";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export_format'])) {
    $format = $_POST['export_format'];

    // Fetch data to export
    $query = "SELECT * FROM applications WHERE is_deleted = 0";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        if ($format === 'pdf') {
            exportToPDF($data);
        } elseif ($format === 'excel') {
            exportToExcel($data);
        }
    } else {
        echo "No records found to export.";
    }
}

function exportToPDF($data) {
    require('fpdf/fpdf.php');

    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 10);

    $headers = [
        'ID' => 10,
        'Full Name' => 40,
        'Email' => 50,
        'Phone' => 30,
        'Position' => 40,
    ];

    //Dyanimcally adjust column width based on content
    foreach($headers as $header => &$width){
        foreach($data as $row){
            $contentWidth = $pdf->GetStringWidth($row[strtolower(str_replace(' ','_',$header))]) + 4;
            if($contentWidth > $width){
                $width = $contentWidth;
            }
        }
    }

    foreach($headers as $header => $width){
        $pdf-> Cell($width, 10, $header, 1, 0, 'C');
    }
    $pdf->Ln();

    // Header
    /*$pdf->Cell(20, 10, 'ID', 1);
    $pdf->Cell(50, 10, 'Full Name', 1);
    $pdf->Cell(60, 10, 'Email', 1);
    $pdf->Cell(30, 10, 'Phone', 1);
    $pdf->Cell(30, 10, 'Position', 1);
    $pdf->Ln();*/

    //Data Rows
    $pdf->SetFont('Arial','',10);
    foreach($data as $row){
        $pdf->Cell($headers['ID'], 10, $row['id'], 1);
        $pdf->Cell($headers['Full Name'], 10, $row['full_name'], 1);
        $pdf->Cell($headers['Email'], 10, $row['email'], 1);
        $pdf->Cell($headers['Phone'], 10, $row['phone'], 1);
        $pdf->Cell($headers['Position'], 10, $row['position'], 1);
        $pdf->Ln();
    }
    // Data
    /*foreach ($data as $row) {
        $pdf->Cell(20, 10, $row['id'], 1);
        $pdf->Cell(50, 10, $row['full_name'], 1);
        $pdf->Cell(60, 10, $row['email'], 1);
        $pdf->Cell(30, 10, $row['phone'], 1);
        $pdf->Cell(30, 10, $row['position'], 1);
        $pdf->Ln();
    }*/

    $pdf->Output('D', 'applications.pdf');
}

function exportToExcel($data) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=applications.xls");

    // Output header row
    echo "ID\tFull Name\tEmail\tPhone\tPosition\n";

    // Output data rows
    foreach ($data as $row) {
        echo $row['id'] . "\t" . 
        $row['full_name'] . "\t" . 
        $row['email'] . "\t" . 
        "'" . $row['phone'] . "\t" . 
        $row['position'] . "\n";
    }
    exit();
}
?>
