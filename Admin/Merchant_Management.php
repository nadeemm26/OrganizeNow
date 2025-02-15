<?php
    include "connection.php";
    include "admin_sidebar.php";
?>
<h1>Merchant Management</h1>
<p>Manage all registered Merchant here.</p>
<a href="merchant_management_addmerchant.php"><button>Add New Merchant</button></a>
<table>
    <thead>
        <tr>
            <th>Merchant Id</th>
            <th>Merchant Name</th>
            <th>Business Details</th>
            <th>Merchant Email</th>
            <th>Merchant Mobile</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Select = "SELECT * FROM `merchant`";
        $data = mysqli_query($conn, $Select);
        while ($row = mysqli_fetch_assoc($data)) {

        ?>
            <tr>
                <td><?php echo $row['merchant_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['details']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['mobile']; ?></td>
                <td class="action-buttons">
                    <button><a href="merchant_management_edit.php?id=<?php echo $row['merchant_id']; ?>">Edit</a></button>
                    <button class="delete"><a href="merchant_management_delete.php?id=<?php echo $row['merchant_id']; ?>" onclick="return confirm('Are you sure you want to delete this merchant?')">Delete</a></button>
                </td>
            </tr>

    <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>