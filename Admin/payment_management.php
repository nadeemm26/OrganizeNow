<link rel="stylesheet" href="table.css">
<?php
    include "connection.php";
    include "admin_sidebar.php";
?>

<h1>Payment Management</h1>
<p>Manage all Payments of registered users here.</p>

<?php
// Fetch Payments with Filters
$conditions = [];
if (!empty($_GET['user_id'])) {
    $conditions[] = "p.user_id = '" . mysqli_real_escape_string($conn, $_GET['user_id']) . "'";
}
if (!empty($_GET['merchant_id'])) {
    $conditions[] = "p.merchant_id = '" . mysqli_real_escape_string($conn, $_GET['merchant_id']) . "'";
}
if (!empty($_GET['booking_id'])) {
    $conditions[] = "p.booking_id = '" . mysqli_real_escape_string($conn, $_GET['booking_id']) . "'";
}

$whereClause = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';
$query = "SELECT p.id, u.name AS user_name, p.user_id, p.merchant_id, p.booking_id, p.amount_paid, p.payment_status, 
                 p.payment_id, p.order_id, p.created_at 
          FROM payments p 
          INNER JOIN user u ON p.user_id = u.user_id 
          $whereClause
          ORDER BY p.created_at DESC";
$result = mysqli_query($conn, $query);
?>

<h2>Payment Management</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>User Information</th>
        <th>Merchant Information</th>
        <th>Booking Information</th>
        <th>Amount</th>
        <th>Payment Status</th>
        <th>Payment ID</th>
        <th>Order ID</th>
        <th>Payment Date</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_name']; ?></td>
            <td><a href="#" class="fetch-data" data-type="user" data-id="<?php echo $row['user_id']; ?>"><?php echo $row['user_id']; ?></a></td>
            <td><a href="#" class="fetch-data" data-type="merchant" data-id="<?php echo $row['merchant_id']; ?>"><?php echo $row['merchant_id']; ?></a></td>
            <td><a href="#" class="fetch-data" data-type="booking" data-id="<?php echo $row['booking_id']; ?>"><?php echo $row['booking_id']; ?></a></td>
            <td>₹<?php echo number_format($row['amount_paid'], 2); ?></td>
            <td><?php echo $row['payment_status']; ?></td>
            <td><?php echo $row['payment_id']; ?></td>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td class="action-buttons">
                <button class="delete"><a href="delete_payment.php?id=<?php echo $row['id']; ?>">Delete</a></button>
            </td>
        </tr>
    <?php } ?>
</table>

<!-- Details Section -->
<div id="details-section" style="display: none;">
    <h3>Details</h3>
    <button id="close-details" style="float: right; background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">Close</button>
    <div id="details-content">Click on User ID, Merchant ID, or Booking ID to see details here.</div>
</div>

<!-- JavaScript for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $(".fetch-data").click(function(){
            var id = $(this).data("id");
            var type = $(this).data("type");

            $.ajax({
                url: "fetch_details.php",
                type: "POST",
                data: { id: id, type: type },
                success: function(response){
                    $("#details-content").html(response);
                    $("#details-section").show(); // Show the details section
                }
            });
        });

        // Close button functionality
        $("#close-details").click(function(){
            $("#details-section").hide(); // Hide the details section
        });
    });
</script>
</body>
</html>
