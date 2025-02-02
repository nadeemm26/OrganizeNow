<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    session_regenerate_id(true); // Regenerate session ID to prevent fixation
    header('Location: index.php'); // Redirect to login page
    exit;
}

$logout_url = 'logout.php';

// Database connection
$conn = new mysqli('localhost', 'root', '', 'event_management');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_event'])) {
        $event_name = $_POST['event_name'];
        $event_description = $_POST['event_description'];
        $event_date = $_POST['event_date'];
        
        // Image upload
        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
            $image_name = $_FILES['event_image']['name'];
            $image_tmp = $_FILES['event_image']['tmp_name'];
            $image_path = 'uploads/' . $image_name;
            move_uploaded_file($image_tmp, $image_path);
        } else {
            $image_path = '';
        }

        // Insert event into the database
        $stmt = $conn->prepare("INSERT INTO events (name, description, date, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $event_name, $event_description, $event_date, $image_path);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['book_event'])) {
        $event_id = $_POST['event_id'];
        $user_id = $_SESSION['user_id'];

        // Insert booking into the database
        $stmt = $conn->prepare("INSERT INTO bookings (event_id, user_id) VALUES (?, ?)");
        $stmt->bind_param('ii', $event_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="dashboard.php">
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=manage_events">
                                Manage Events
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $logout_url; ?>">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php
                if (isset($_GET['page']) && $_GET['page'] === 'manage_events') {
                    ?>
                    <h2>Manage Events</h2>
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="?page=manage_events&action=add">Add New Event</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?page=manage_events&action=view">View All Events</a>
                        </li>
                    </ul>

                    <?php
                    if (isset($_GET['action']) && $_GET['action'] === 'add') {
                        ?>
                        <form method="post" enctype="multipart/form-data" class="mt-4">
                            <div class="mb-3">
                                <label for="event_name" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="event_description" class="form-label">Event Description</label>
                                <textarea class="form-control" id="event_description" name="event_description" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="event_date" class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="event_date" name="event_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="event_image" class="form-label">Event Image</label>
                                <input type="file" class="form-control" id="event_image" name="event_image" accept="image/*">
                            </div>
                            <button type="submit" name="add_event" class="btn btn-primary">Add Event</button>
                        </form>
                        <?php
                    } elseif (isset($_GET['action']) && $_GET['action'] === 'view') {
                        $result = $conn->query("SELECT * FROM events");
                        ?>
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Image</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><?php echo $row['date']; ?></td>
                                        <td><img src="<?php echo $row['image']; ?>" alt="Event Image" style="width: 100px;"></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php
                    }
                } else {
                    ?>
                    <h1>Welcome to the Event Management Dashboard</h1>
                    <?php
                }
                ?>
            </main>
        </div>
    </div>
</body>

</html>
