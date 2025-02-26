<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '/opt/lampp/htdocs/tcpdf/tcpdf.php';

$conn = new mysqli('localhost', 'root', '', 'febnew');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = null;
$message = '';

// Removed merchant types query and array

function generatePDF($result, $start_date, $end_date) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Organization');
    $pdf->SetTitle('Merchant Report');
    
    // Set margins
    $pdf->SetMargins(10, 15, 10); // Reduced left and right margins
    
    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Add a page
    $pdf->AddPage('L', 'A4'); // Landscape orientation
    
    // Set font
    $pdf->SetFont('helvetica', '', 10);
    
    // Title
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Merchant Report', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    
    // Filter information
    $pdf->Cell(0, 5, 'Date Range: ' . $start_date . ' to ' . $end_date, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Table header
    $pdf->SetFillColor(240, 240, 240);
    $pdf->SetFont('helvetica', 'B', 8);
    
    // Adjusted column widths (total should be around 270 for A4 Landscape)
    $header = array('ID', 'Name', 'Details', 'Email', 'Mobile', 'Created');
    $widths = array(15, 25, 125, 35, 35, 35); // 270 Increased width for Requests column
    
    // Calculate Cell Height for header
    $cellHeight = 7;
    
    foreach($header as $i => $col) {
        $pdf->Cell($widths[$i], $cellHeight, $col, 1, 0, 'C', true);
    }
    $pdf->Ln();
    
    // Table data
    $pdf->SetFont('helvetica', '', 8);
    
    // Enable automatic page break
    $pdf->SetAutoPageBreak(true, 15);
    
    while ($row = $result->fetch_assoc()) {
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $maxHeight = 6; // Minimum height
        
        // Pre-calculate heights needed for each cell
        $heights = array();
        
        // Calculate required height for each cell
        $pdf->SetFont('helvetica', '', 8);
        $texts = array(
            $row['merchant_id'],
            $row['name'],
            // $row['type'],
            $row['details'],
            $row['email'],
            $row['mobile'],
            $row['created'],
        );
        
        foreach($texts as $i => $text) {
            $heights[$i] = $pdf->getStringHeight($widths[$i], $text);
            $maxHeight = max($maxHeight, $heights[$i]);
        }
        
        // Check if we need to add a new page
        if ($y + $maxHeight > $pdf->getPageHeight() - 15) {
            $pdf->AddPage('L');
            $y = $pdf->GetY();
        }
        
        // Reset X position
        $pdf->SetXY($x, $y);
        
        // Print cells with calculated height
        foreach($texts as $i => $text) {
            // MultiCell for text wrapping
            $pdf->MultiCell($widths[$i], $maxHeight, $text, 1, 'L', false, 0);
        }
        
        $pdf->Ln($maxHeight);
    }
    
    // Output PDF
    $pdf->Output('merchant_report.pdf', 'D');
    exit();
}

// Only run query if form is submitted
if (isset($_POST['submit']) || isset($_POST['download_pdf'])) {
    if (empty($_POST['start_date']) || empty($_POST['end_date'])) {
        $message = '<div style="color: red;">Please enter both start and end dates</div>';
    } else {
        $start_date = $conn->real_escape_string($_POST['start_date']);
        $end_date = $conn->real_escape_string($_POST['end_date']);

        // Add time to make the end date inclusive
        $end_date = date('Y-m-d', strtotime($end_date . '+1 day'));

        // Simplified query without type filter
        $sql = "SELECT merchant_id, name, details, email, mobile, created 
                FROM merchant 
                WHERE created BETWEEN ? AND ?
                ORDER BY created DESC";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $start_date, $end_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = '<div style="color: blue;">No records found for the selected criteria</div>';
        } elseif (isset($_POST['download_pdf'])) {
            // If download button was clicked, generate PDF
            generatePDF($result, $_POST['start_date'], $_POST['end_date']);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Merchant Report</title>
    <link rel="stylesheet" href="styles12.css">
</head>
<body>
    <h2>Merchant Report</h2>
    
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
                <?php if (isset($result) && $result->num_rows > 0): ?>
                    <button type="submit" name="download_pdf" class="button">Download PDF</button>
                <?php endif; ?>
                <a href="<?php echo $_SERVER['PHP_SELF']; ?>" class="button">Reset</a>
            </div>
        </form>
    </div>

    <?php echo $message; ?>

    <?php if ($result): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <!-- <th>Merchant Type</th> -->
                    <th>Details</th>
                    <th>Email</th>
                    <th>Mobile Number</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['merchant_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <!-- <td><?php echo htmlspecialchars($row['type']); ?></td> -->
                        <td><?php echo htmlspecialchars($row['details']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['mobile']); ?></td>
                        <td><?php echo htmlspecialchars($row['created']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>