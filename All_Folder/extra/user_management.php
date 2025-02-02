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
<table>
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
                data: { id: userId },
                success: function (response) {
                    alert('User deleted successfully!');
                    location.reload();
                },
                error: function () {
                    alert('Error deleting user.');
                }
            });
        }
    }
</script>
