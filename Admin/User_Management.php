<link rel="stylesheet" href="table.css">
<?php
include "connection.php";
include "admin_sidebar.php";
?>
<h1>User Management</h1>
<p>Manage all registered User here.</p>
<a href="user_management_adduser.php"><button>Add New User</button></a>
<table>
    <thead>
        <tr>
            <th>User Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Select = "SELECT * FROM `user`";
        $data = mysqli_query($conn, $Select);
        while ($row = mysqli_fetch_assoc($data)) {

        ?>

            <tr>
                <td><?php echo $row['user_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td class="action-buttons">
                    <button><a href="user_management_edit.php?id=<?php echo $row['user_id']; ?>">Edit</a></button>
                    <button class="delete"><a href="user_management_delete.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></button>
                </td>
            </tr>

        <?php } ?>
    </tbody>
</table>
</div>
</body>

</html>