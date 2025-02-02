<!-- <?php include 'sidebar.php'; ?> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="sidebar.css">
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
        <a href="<?php echo $logout_url; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <script src="script.js"></script>
    </body>
</html>
