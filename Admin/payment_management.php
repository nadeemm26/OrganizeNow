<?php
    include "connection.php";
    include "admin_sidebar.php";
?>

        <h1>Payment Management</h1>
        <p>Manage All Registered Events Payments.</p>
        <table>
            <thead>
                <tr>
                    <th>Payment Id</th>
                    <th>Booking Id</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Mobile</th>
                    <th>Merchant Name</th>
                    <th>Service/Event</th>
                    <th>Payment Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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