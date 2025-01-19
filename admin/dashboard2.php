<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php'); // Redirect to login page
    exit;
}

// Logout URL
$logout_url = 'logout.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 220px;
            background-color: #2c3e50;
            color: #ecf0f1;
            height: 100vh;
            position: fixed;
            padding-top: 20px;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar img {
            width: 80px;
            height: 70px;
            border-radius: 53%;
            margin-bottom: -19px;
            padding: 4px 30px;
        }

        .sidebar a {
            text-decoration: none;
            color: #ecf0f1;
            display: block;
            padding: 12px 15px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 5px 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .user-info span {
            font-size: 16px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            /* position: fixed;
            padding-top: 20px;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1); */
        }

        .dashboard-header h1 {
            margin: 0;
        }

        .reports-table,
        .reports-table td,
        .reports-table th {
            border: 1px solid #ddd;
            border-collapse: collapse;
            padding: 8px;
            text-align: left;
        }

        .reports-table {
            width: 100%;
            margin-top: 20px;
        }

        .chart-container {
            width: 300px;
            height: 300px;
            margin: 20px auto;
        }

        /* .table{
            margin-left: 20px;
        } */
        /* start */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
            color: #333;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .add-user {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            float: right;
            margin-bottom: 10px;

        }

        table td button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
        }

        table td button:hover {
            background-color: #45a049;
        }

        /* form {
            display: inline;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 3px;
        } */
        h2 {
            margin-top: 40px;
        }

        /* Modal container */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        /* Modal content */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 8px;
            width: 40%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <img alt="Event Management Logo" height="50" src="https://storage.googleapis.com/a1aa/image/lVCW4JSGXNpeEqSD67RZn3Gu7QmvDyhmjWDeAqe4rVcfR5DQB.jpg" width="50" />
        <h2>OrganizeNow</h2>
        <a href="#dashboard" onclick="showSection('dashboard')"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        <a href="#user" onclick="showSection('user-management')"><i class="fas fa-users"></i> User Management</a>
        <a href="#merchant-management" onclick="showSection('merchant-management')"><i class="fas fa-store"></i> Merchant Management</a>
        <a href="#payment-management" onclick="showSection('payment-management')"><i class="fas fa-credit-card"></i> Payment Management</a>
        <a href="#settings" onclick="showSection('settings')"><i class="fas fa-cogs"></i> Settings</a>
        <a href="<?php echo $logout_url; ?>"><i class="fas fa-cogs"></i> Logout</a>
    </div>

    <div class="main-content">
        <!-- Dashboard -->
        <div id="dashboard" class="section">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <div class="search-bar">
                    <input placeholder="Search..." type="text" />
                </div>
                <div class="user-info">
                    <img alt="User Avatar" height="40" src="https://storage.googleapis.com/a1aa/image/e36lXxKb7ayf6USC6uReBg8wMsEnnQRRKftAJ6XNwH6mM5DQB.jpg" width="40" />
                    <span>Nadeem Makwana</span>
                </div>
                <div class="clock-container" id="clock">
                    <!-- The live clock will display here -->
                </div>
                <!-- <p>Thursday, August 1, 2024 | 9:10 PM</p> -->
            </div>
            <div>
                <h2>Reports</h2>
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Orders</th>
                            <th>Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>New Order</td>
                            <td>150</td>
                        </tr>
                        <tr>
                            <td>Confirmed Order</td>
                            <td>8</td>
                        </tr>
                        <tr>
                            <td>Pickup Order</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>On the way order</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Delivered Order</td>
                            <td>35</td>
                        </tr>
                        <tr>
                            <td>Cancelled Order</td>
                            <td>10</td>
                        </tr>
                    </tbody>
                </table>
                <div class="chart-container">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div id="user-management" class="section" style="display: none;">
            <?php
            // Connect to the database
            // Replace these credentials with your actual database details
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'um'; // Replace with your database name

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Fetch customers from the database
            $query = 'SELECT * FROM user'; // Replace 'customers' with your table name
            $result = $conn->query($query);
            ?>

            <h2>User Management</h2>
            <p>Manage all registered users here.</p>
            <!-- <button class="add-user">Add User</button> -->
            <!-- Add User Button -->
            <button id="addUserBtn">Add User</button>

            <!-- Popup Modal -->
            <div id="addUserModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Register User</h2>
                    <form id="registerUserForm">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>

                        <button type="submit">Register</button>
                    </form>
                </div>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile']; ?></td>
                                <td>
                                    <button onclick="editUser(<?php echo $row['id']; ?>)">Edit</button>
                                    <button onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <script>
                function editUser(userId) {
                    alert('Edit functionality for user ID: ' + userId + ' coming soon!');
                    // You can open a modal or redirect to another page for editing
                }

                function deleteUser(userId) {
                    if (confirm('Are you sure you want to delete this user?')) {
                        $.ajax({
                            url: 'delete_user.php',
                            method: 'POST',
                            data: {
                                id: userId
                            },
                            success: function(response) {
                                alert('User deleted successfully!');
                                location.reload();
                            },
                            error: function() {
                                alert('Error deleting user.');
                            }
                        });
                    }
                }
            </script>

            <!-- <h2>User Management</h2> -->

        </div>

        <!-- Merchant Management -->
        <div id="merchant-management" class="section" style="display: none;">
            <?php
            // Connect to the database
            // Replace these credentials with your actual database details
            $host = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'um'; // Replace with your database name

            $conn = new mysqli($host, $username, $password, $database);

            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }

            // Fetch customers from the database
            $query = 'SELECT * FROM merchant'; // Replace 'customers' with your table name
            $result = $conn->query($query);
            ?>

            <h2>Merchant Management</h2>
            <p>Manage all registered Merchant here.</p>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['type']; ?></td>
                                <td><?php echo $row['details']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['mobile']; ?></td>
                                <td>
                                    <button onclick="editUser(<?php echo $row['id']; ?>)">Edit</button>
                                    <button onclick="deleteUser(<?php echo $row['id']; ?>)">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <script>
                function editUser(userId) {
                    alert('Edit functionality for user ID: ' + userId + ' coming soon!');
                    // You can open a modal or redirect to another page for editing
                }

                function deleteUser(userId) {
                    if (confirm('Are you sure you want to delete this user?')) {
                        $.ajax({
                            url: 'delete_user.php',
                            method: 'POST',
                            data: {
                                id: userId
                            },
                            success: function(response) {
                                alert('User deleted successfully!');
                                location.reload();
                            },
                            error: function() {
                                alert('Error deleting user.');
                            }
                        });
                    }
                }
            </script>
        </div>

        <!-- Payment Management -->
        <div id="payment-management" class="section" style="display: none;">
            <h2>Payment Management</h2>
            <p>View and manage all payment transactions.</p>
        </div>

        <!-- Settings -->
        <div id="settings" class="section" style="display: none;">
            <h2>Settings</h2>
            <p>Configure application settings.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Setup
        const ctx = document.getElementById('orderChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['New Order', 'Confirmed Order', 'Pickup Order', 'On the way', 'Delivered', 'Cancelled'],
                datasets: [{
                    data: [150, 8, 30, 50, 35, 10],
                    backgroundColor: ['#2ecc71', '#3498db', '#9b59b6', '#e67e22', '#e74c3c', '#95a5a6']
                }]
            }
        });

        // Section Navigation
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
    <!-- script for time................... -->
    <script>
        function updateClock() {
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            const now = new Date();
            const dayName = days[now.getDay()];
            const monthName = months[now.getMonth()];
            const date = now.getDate();
            const year = now.getFullYear();

            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const amPm = hours >= 12 ? 'PM' : 'AM';

            hours = hours % 12 || 12; // Convert to 12-hour format

            const timeString = `${dayName} ${monthName} ${date}, ${year} ${hours}:${minutes}${amPm}`;

            document.getElementById("clock").textContent = timeString;
        }

        // Update the clock every second
        setInterval(updateClock, 1000);
        updateClock(); // Initial call to display immediately
    </script>
    <!-- .................................. -->
    <!-- script for add user in admin -->
    <script>
        // Get elements
        const addUserBtn = document.getElementById('addUserBtn');
        const modal = document.getElementById('addUserModal');
        const closeBtn = document.querySelector('.close');

        // Show modal on button click
        addUserBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        // Close modal when the close button is clicked
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside the modal content
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    </script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->

</body>

</html>