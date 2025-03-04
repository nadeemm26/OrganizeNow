<?php
include "../connection.php";
include "admin_sidebar.php";
?>

<style>
    .dashboard-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background: #2c3e50;
        color: white;
        border-radius: 8px;
    }
    .dashboard-header a{
        text-decoration: none;
        color: white;
    }
    .search-bar input {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .reports-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background: #ecf0f1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .reports-table th, .reports-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .reports-table th {
        background: #34495e;
        color: white;
    }
    .chart-container {
        margin-top: 20px;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>

<?php
// Admin ID from session (Assuming admin logged in)
$admin_id = $_SESSION['admin_id']; 

// Fetch admin details from database
$query = "SELECT username, profile_image FROM admin WHERE admin_id = '$admin_id'";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Default profile image if not set
$profile_image = !empty($admin['profile_image']) ? $admin['profile_image'] : 'default_avatar.png';
?>

<div id="dashboard" class="section">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <div class="user-info">
            <img src="uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="User Avatar" width="40" height="40" />
            <span><?php echo htmlspecialchars($admin['username']); ?></span>
        </div>
        <a href="edit_profile.php">Edit Profile</a> 
    </div>
</div>

    <div>
        <h2>Reports</h2>
        <table class="reports-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Count</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $categories = [
                    'Users' => "SELECT COUNT(*) as count FROM user",
                    'Merchants' => "SELECT COUNT(*) as count FROM merchant",
                    'Venue Service' => "SELECT COUNT(*) as count FROM venue_booking",
                    'Catering Service' => "SELECT COUNT(*) as count FROM catering_service",
                    'Decoration Service' => "SELECT COUNT(*) as count FROM decoration_service",
                    'Photography Service' => "SELECT COUNT(*) as count FROM photography_service",
                    'Entertainment Service' => "SELECT COUNT(*) as count FROM entertainment_service",
                    'Bookings' => "SELECT COUNT(*) as count FROM booking2",
                    'Payments' => "SELECT COUNT(*) as count FROM payments"
                ];
                
                $chartData = [];
                foreach ($categories as $name => $query) {
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $count = $row['count'];
                    echo "<tr><td>$name</td><td>$count</td></tr>";
                    $chartData[$name] = $count;
                }
                ?>
            </tbody>
        </table>
        <div class="chart-container">
            <canvas id="reportChart"></canvas>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('reportChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_keys($chartData)); ?>,
            datasets: [{
                label: 'Total Count',
                data: <?php echo json_encode(array_values($chartData)); ?>,
                backgroundColor: ['#2ecc71', '#3498db', '#9b59b6', '#e67e22', '#e74c3c', '#95a5a6', '#f39c12', '#1abc9c', '#d35400']
            }]
        }
    });
</script>
