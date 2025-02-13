<?php
include 'user_navbar.php';
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entertainment Services</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .card-body {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center mb-4">Entertainment Services</h2>
    <div class="row">
        <?php
        $query = "SELECT * FROM entertainment_service";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="../Merchant/<?php echo $row['event_image']; ?>" class="card-img-top" alt="Event Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['service_type']; ?></h5>
                            <p><strong>Duration:</strong> <?php echo $row['performance_duration']; ?></p>
                            <p><strong>Basic Price:</strong> ₹<?php echo number_format($row['price'], 2); ?></p>
                            
                            <!-- Book Now Button with Modal Trigger -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookingModal"
                                data-service-id="<?php echo $row['entertainment_id']; ?>"
                                data-service-type="<?php echo $row['service_type']; ?>"
                                data-price="<?php echo $row['price']; ?>">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p class='text-center'>No entertainment services available.</p>";
        }
        ?>
    </div>
</div>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingModalLabel">Book Entertainment Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="process_booking.php" method="POST">
                    <input type="hidden" name="service_id" id="service_id">
                    <input type="hidden" name="service_type" id="service_type">
                    
                    <div class="mb-3">
                        <label class="form-label">Selected Service</label>
                        <input type="text" class="form-control" id="selected_service" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" disabled>
                    </div>
                    
                    <div class="mb-3">
                        <label for="booking_date" class="form-label">Select Date</label>
                        <input type="date" class="form-control" name="booking_date" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" name="customer_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" name="customer_email" required>
                    </div>

                    <div class="mb-3">
                        <label for="customer_mobile" class="form-label">Your Mobile</label>
                        <input type="text" class="form-control" name="customer_mobile" required>
                    </div>

                    <button type="submit" class="btn btn-success">Confirm Booking</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var bookingModal = document.getElementById("bookingModal");
        bookingModal.addEventListener("show.bs.modal", function (event) {
            var button = event.relatedTarget;
            var serviceId = button.getAttribute("data-service-id");
            var serviceType = button.getAttribute("data-service-type");
            var price = button.getAttribute("data-price");

            document.getElementById("service_id").value = serviceId;
            document.getElementById("service_type").value = serviceType;
            document.getElementById("selected_service").value = serviceType;
            document.getElementById("price").value = "₹" + parseFloat(price).toFixed(2);
        });
    });
</script>

</body>
</html>
