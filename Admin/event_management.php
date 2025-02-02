<?php
    include "connection.php";
    include "admin_sidebar.php";
?>

<h1>Event Management</h1>
        <p>Manage all registered Events here.</p>
        <table>
            <thead>
                <tr>
                    <th>Event Id</th>
                    <th>Event Name</th>
                    <th>Service Type</th>
                    <th>Event Description</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Created_at</th>
                    <th>Merchant_id</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>7</td>
                    <td>Birthday Party</td>
                    <td>Photo</td>
                    <td>For birthday party</td>
                    <td>Sector 21</td>
                    <td>21-01-2025</td>
                    <td>10.45.23</td>
                    <td>12</td>
                    <td>no image</td>
                    <td class="action-buttons">
                        <button>Edit</button>
                        <button class="delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>