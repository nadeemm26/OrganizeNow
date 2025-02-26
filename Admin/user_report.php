<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'C:/xampp/htdocs/OrganizeNow/Customer/TCPDF/tcpdf.php';


$conn = new mysqli('localhost', 'root', '', 'um');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = null;
$data = null;
$message = '';

function generatePDF($data, $start_date, $end_date) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Organization');
    $pdf->SetTitle('User Report');
    $pdf->SetMargins(10, 15, 10);
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->AddPage('L', 'A4');
    
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'User Report', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    
    $pdf->Cell(0, 5, 'Date Range: ' . $start_date . ' to ' . $end_date, 0, 1, 'L');
    $pdf->Ln(5);
    
    $header = array('ID', 'Name', 'Email', 'Mobile', 'Created');
    $widths = array(30, 60, 70, 50, 60); // Total 270 for A4 Landscape
    
    $pdf->SetFillColor(240, 240, 240);
    $pdf->SetFont('helvetica', 'B', 9);
    
    foreach($header as $i => $col) {
        $pdf->Cell($widths[$i], 7, $col, 1, 0, 'C', true);
    }
    $pdf->Ln();
    
    $pdf->SetFont('helvetica', '', 9);
    $pdf->SetAutoPageBreak(true, 15);
    
    foreach($data as $row) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $maxHeight = 6;
        
        $texts = array(
            $row['user_id'],
            $row['name'],
            $row['email'],
            $row['mobile'],
            $row['created_at']
        );
        
        foreach($texts as $i => $text) {
            $heights[$i] = $pdf->getStringHeight($widths[$i], $text);
            $maxHeight = max($maxHeight, $heights[$i]);
        }
        
        if ($y + $maxHeight > $pdf->getPageHeight() - 15) {
            $pdf->AddPage('L');
            $y = $pdf->GetY();
        }
        
        $pdf->SetXY($x, $y);
        
        foreach($texts as $i => $text) {
            $pdf->MultiCell($widths[$i], $maxHeight, $text, 1, 'L', false, 0);
        }
        
        $pdf->Ln($maxHeight);
    }
    
    $pdf->Output('user_report.pdf', 'D');
    exit();
}

if (isset($_POST['submit']) || isset($_POST['download_pdf'])) {
    if (empty($_POST['start_date']) || empty($_POST['end_date'])) {
        $message = '<div style="color: red;">Please enter both start and end dates</div>';
    } else {
        $start_date = $conn->real_escape_string($_POST['start_date']);
        $end_date = $conn->real_escape_string($_POST['end_date']);
        $end_date = date('Y-m-d', strtotime($end_date . '+1 day'));
        
        $sql = "SELECT user_id, name, email, mobile, created_at 
                FROM user 
                WHERE created_at BETWEEN ? AND ?
                ORDER BY created_at DESC";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        
        if (empty($data)) {
            $message = '<div style="color: blue;">No records found for the selected date range</div>';
        } elseif (isset($_POST['download_pdf'])) {
            generatePDF($data, $_POST['start_date'], $_POST['end_date']);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Report</title>
    <style>
        body { padding: 20px; font-family: Arial, sans-serif; }
        .form-container { margin-bottom: 20px; }
        .form-group { margin: 10px 0; }
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .button { padding: 5px 15px; margin-right: 10px; }
    </style>
    <!-- <link rel="stylesheet" href="styles12.css">  -->
</head>
<body>
    <h2>User Report</h2>
    
    <div class="form-container">
        <form method="post" action="">
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" 
                       value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" 
                       value="<?php echo isset($_POST['end_date']) ? htmlspecialchars($_POST['end_date']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <button type="submit" name="submit" class="button">Filter</button>
                <?php if (!empty($data)): ?>
                    <button type="submit" name="download_pdf" class="button">Download PDF</button>
                <?php endif; ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="button">Reset</a>
            </div>
        </form>
    </div>

    <?php echo $message; ?>

    <?php if (!empty($data)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>