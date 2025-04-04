<link rel="stylesheet" href="table.css">
<?php 

include "connection.php";
include "admin_sidebar.php"; 

?>
<style>
    #reportForm {
        background: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 5000px;
        margin: 20px auto;
        /* display: flex; */
        /* flex-direction: column; */
        /* gap: 15px; */
    }

    /* Labels */
    .lab {
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }

    /* Dropdown & Date Inputs */
    .select,
    .input {
        width: 15%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        background: white;
    }

    /* Button */
    .bb {
        background: linear-gradient(to bottom, #4CAF50, #2E7D32);
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s ease;
    }

    .bb:hover {
        background: linear-gradient(to bottom, #66BB6A, #388E3C);
        box-shadow: 0px 6px #1B5E20;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
        #reportForm {
            max-width: 100%;
            padding: 15px;
        }

        .select,
        .input {
            font-size: 12px;
        }

        .bb {
            font-size: 14px;
        }
    }
</style>
<h1>Generate Reports</h1>
<p>Filter User, Merchant, Booking, and Payment data by date and table selection.</p>

<!-- Report Filter Form -->
<form id="reportForm" class="1">
    <label class="lab">Select Table:</label>
    <select class="select" id="table_name" name="table_name" required>
        <option value="">-- Select Table --</option>
        <option value="user">User</option>
        <option value="merchant">Merchant</option>
        <option value="booking2">Booking</option>
        <option value="payments">Payment</option>
    </select>

    <label class="lab">From Date:</label>
    <input class="input" type="date" id="from_date" name="from_date" required>

    <label class="lab">To Date:</label>
    <input class="input" type="date" id="to_date" name="to_date" required>

    <button class="bb" type="submit">Generate Report</button>
</form>

<!-- Report Section -->
<div id="report-section" style="display: none;">
    <h3>Report Data</h3>
    <button id="close-report" style="float: right; background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;">Close</button>
    <button id="download-pdf" style="background-color: green; color: white; border: none; padding: 5px 10px; cursor: pointer;">Download PDF</button>
    <div id="report-content">Select a table and date range to generate a report.</div>
</div>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#reportForm").submit(function(e) {
            e.preventDefault(); // Prevent page reload

            var table_name = $("#table_name").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();

            if (table_name == "") {
                alert("Please select a table.");
                return;
            }

            $.ajax({
                url: "fetch_report.php",
                type: "POST",
                data: {
                    table_name: table_name,
                    from_date: from_date,
                    to_date: to_date
                },
                success: function(response) {
                    $("#report-content").html(response);
                    $("#report-section").show();
                }
            });
        });

        // Close button functionality
        $("#close-report").click(function() {
            $("#report-section").hide();
        });

        // PDF Download Button
        $("#download-pdf").click(function() {
            var table_name = $("#table_name").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();

            if (table_name == "") {
                alert("Please select a table.");
                return;
            }

            window.location.href = "generate_pdf.php?table_name=" + table_name + "&from_date=" + from_date + "&to_date=" + to_date;
        });
    });
</script>
</body>

</html>