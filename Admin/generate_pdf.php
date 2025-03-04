<?php
require('../Customer/TCPDF/tcpdf.php'); // Include TCPDF from the customer folder
include "connection.php";

if (isset($_GET['table_name']) && isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $table_name = $_GET['table_name'];
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];

    // Create PDF Object
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Admin');
    $pdf->SetTitle('Report Data');
    $pdf->SetHeaderData('', 0, $table_name.' Report', "Date Range: $from_date to $to_date");
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetMargins(10, 20, 10);
    $pdf->SetAutoPageBreak(TRUE, 10);
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 10);

    // Define query based on table selection
    switch ($table_name) {
        case "user":
            $query = "SELECT user_id AS ID, name AS Name, email AS Email, created_at AS 'Created At' FROM user WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;
        case "merchant":
            $query = "SELECT merchant_id AS ID, name AS Name, email AS Email, created_at AS 'Created At' FROM merchant WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;
        case "booking2":
            $query = "SELECT booking_id AS ID, user_id AS 'User ID', merchant_id AS 'Merchant ID', amount AS Amount, status AS Status, created_at AS 'Created At' FROM bookings WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;
        case "payments":
            $query = "SELECT id AS ID, user_id AS 'User ID', merchant_id AS 'Merchant ID', amount_paid AS 'Amount Paid', payment_status AS 'Payment Status', created_at AS 'Created At' FROM payments WHERE created_at BETWEEN '$from_date' AND '$to_date'";
            break;
        default:
            $pdf->Cell(0, 10, 'Invalid table selected.', 0, 1, 'C');
            $pdf->Output('report.pdf', 'D'); // Download PDF
            exit();
    }

    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $tableHTML = '<table border="1" cellspacing="0" cellpadding="5">';
        
        // Add column headers
        $columns = array_keys(mysqli_fetch_assoc($result));
        mysqli_data_seek($result, 0);
        $tableHTML .= '<tr>';
        foreach ($columns as $col) {
            $tableHTML .= "<th>$col</th>";
        }
        $tableHTML .= '</tr>';

        // Add data rows
        while ($row = mysqli_fetch_assoc($result)) {
            $tableHTML .= '<tr>';
            foreach ($row as $value) {
                $tableHTML .= "<td>$value</td>";
            }
            $tableHTML .= '</tr>';
        }
        $tableHTML .= '</table>';

        $pdf->writeHTML($tableHTML, true, false, true, false, '');
    } else {
        $pdf->Cell(0, 10, 'No data found for the selected table and date range.', 0, 1, 'C');
    }

    $pdf->Output('report.pdf', 'D'); // Download the PDF
}
?>
