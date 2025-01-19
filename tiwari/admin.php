<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>OrganizeNow Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <img src="c:\Users\Bhagya Tiwari\Downloads\download.jpeg" alt="Admin Profile">
            <h3>Bhagya Tiwari</h3>
        </div>
        <ul>
            <li>Overview</li>
            <li>Transactions</li>
            <li>Activity</li>
            <li>Setting</li>
            <li>Log Out</li>
        </ul>
    </div>
    <div class="main">
       <!-- <div class="header">
            <h1>Hello Admin !!</h1> -->
            <div class="search-container">
  <input type="text" placeholder="Search..." id="search-input">
  <button type="submit" id="search-button">Search</button>
</div>
            <div class="icons">
                <button>Email</button>
                <button>Notifications</button>
            </div>
        </div>
        <div class="chart">
            <h2>Visitor Statistics</h2>
            <canvas id="visitorChart"></canvas>
        </div>
        <div class="card-container">
            <div class="card">
                <h3>Total Revenue</h3>
                <p>$500K</p>
            </div>
            <div class="card">
                <h3>Total Sales</h3>
                <p>$120K</p>
            </div>
            <div class="card">
                <h3>Clients</h3>
                <p>123</p>
            </div>
            <div class="card">
                <h3>New Users</h3>
                <p>1450</p>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('visitorChart').getContext('2d');
        const visitorChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Feb 1', 'Feb 5', 'Feb 10', 'Feb 15'],
                datasets: [{
                    label: 'Visitors',
                    data: [40000, 60000, 80000, 70000],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>

