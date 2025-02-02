<?php
include "connection.php";
include "admin.php";
?>
<h1>Merchant Management</h1>
<p>Manage all registered Merchant here.</p>
<a href="merchant_management_addmerchant.php"><button>Add New Merchant</button></a>
<table>
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
        <?php
        $Select = "SELECT * FROM `merchant`";
        $data = mysqli_query($con, $Select);
        while ($row = mysqli_fetch_assoc($data)) {

        ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['type']; ?></td>
                <td><?php echo $row['details']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td class="action-buttons">
                    <button><a href="merchant_management_edit.php?id=<?php echo $row['id']; ?>">Edit</a></button>
                    <button class="delete"><a href="merchant_management_delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this merchant?')">Delete</a></button>
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>