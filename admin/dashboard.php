<?php
    include "connection.php";
    include "admin_sidebar.php";
?>

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
        <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
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
    </script>