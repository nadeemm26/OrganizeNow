<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the TCPDF library
require_once '/opt/lampp/htdocs/tcpdf/tcpdf.php';

$conn = new mysqli('localhost', 'root', '', 'febnew');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = null;
$message = '';

// Function to generate PDF
function generatePDF($result, $start_date, $end_date) {
    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Organization');
    $pdf->SetTitle('Event Report');
    
    // Set margins
    $pdf->SetMargins(10, 15, 10);
    
    // Remove default header/footer
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    
    // Add a page
    $pdf->AddPage('L', 'A4'); // Landscape orientation
    
    // Set font
    $pdf->SetFont('helvetica', '', 10);
    
    // Title
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Event Report', 0, 1, 'C');
    $pdf->SetFont('helvetica', '', 10);
    
    // Filter information
    $pdf->Cell(0, 5, 'Date Range: ' . $start_date . ' to ' . $end_date, 0, 1, 'L');
    $pdf->Ln(5);
    
    // Table header
    $pdf->SetFillColor(240, 240, 240);
    $pdf->SetFont('helvetica', 'B', 8);
    
    // Adjusted column widths for actual database columns
    $header = array('ID', 'Event Name', 'Description', 'Price', 'Merchant ID', 'Created At');
    $widths = array(20, 60, 80, 30, 30, 50);
    
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
        
        // Calculate required height for each cell based on actual database columns
        $pdf->SetFont('helvetica', '', 8);
        $texts = array(
            $row['event_id'],
            $row['event_name'],
            $row['event_description'],
            $row['event_price'],
            $row['merchant_id'],
            $row['created']
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
    $pdf->Output('event_report.pdf', 'D');
    exit();
}

// Handle form submission
if (isset($_POST['submit']) || isset($_POST['download_pdf'])) {
    if (empty($_POST['start_date']) || empty($_POST['end_date'])) {
        $message = '<div style="color: red;">Please enter both start and end dates</div>';
    } else {
        $start_date = $conn->real_escape_string($_POST['start_date']);
        $end_date = $conn->real_escape_string($_POST['end_date']);

        // Add time to make the end date inclusive
        $end_date = date('Y-m-d', strtotime($end_date . '+1 day'));

        // Updated query to match actual database structure
        $sql = "SELECT event_id, event_name, event_description, event_price, merchant_id, created 
                FROM event 
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
    <title>Event Report</title>
    <link rel="stylesheet" href="styles12.css">
</head>
<body>
    <h2>Event Report</h2>
    
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
            
            <div class="form-group button-group">
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
                    <th>Event ID</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Merchant ID</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_description']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['merchant_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['created']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>