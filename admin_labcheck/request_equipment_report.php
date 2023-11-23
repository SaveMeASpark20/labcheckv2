<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
        header("Location: ../index.php");
        exit();
    }

    $page = "Equipment Report";
    include '../partial/admin_sidebar.php';
    include '../partial/header.php';

    $requestType = "equipment";
    $status = "approve"; // Approved status
    $rejectStatus = "reject"; // reject status

    try {
        require_once "../connection/database.php";

        $sql='SELECT r.request_id, r.user_id, r.ticket_no, r.name, r.description, r.time, r.time_end, r.date, r.room_id, r.status, r.feedback, r.school_year, r.semester
            FROM request r
            JOIN academic_year ay
            ON r.school_year = ay.school_year AND r.semester = ay.semester
            WHERE ay.status = 1
            AND r.request_type = ?
            AND (r.status = ? OR r.status = ? )
            ORDER BY r.school_year, r.semester, r.request_id DESC';

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $requestType, $status, $rejectStatus);
        $stmt->execute();
        $result = $stmt->get_result();
    } catch (Exception $e) {
        // Handle database errors here.
        die('Database error: ' . $e->getMessage());
    }
    
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="print.css">
</head>
<body>
<main  class="request-equipment">
<div class="print-search">
    <button id="printButton">Print</button>
    <input type="text" id="searchInput" placeholder="Search">
    <button id="searchButton">Search</button>
</div>
<div class="main-content">
    
    <div class="table-container">
        <div class="table-header">
            <table id="reportTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Name</th>
                        <th>Ticket No.</th>
                        <th>Room No.</th>
                        <th>Description</th>
                        <th>Time Needed</th>
                        <th>Time End</th>
                        <th>Date Needed</th>
                        <th>Status</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table rows here -->
                    <?php
                    $currentSchoolYear = '';
                    $currentSemester = '';
                     while ($row = $result->fetch_assoc()): ?>
                     
                        <?php
                            $time = strtotime($row['time']);
                            $formattedTime = date("g:i A", $time);
                            $time_end = strtotime($row['time_end']);
                            $formattedTimeEnd = $time_end !== false ? date("g:i A", $time_end) : ' ';
                            $date = strtotime($row['date']);
                            $formattedDate = date("F j, Y ", $date);
                            $schoolYear = $row['school_year'];
                            $semester = $row['semester'];
                        ?>
                        <?php if ($currentSchoolYear != $schoolYear || $currentSemester != $semester): ?>
                            <tr>
                                <td data-cell="School Year and Semester" colspan="10" class="group-header">
                                        <?php echo $schoolYear. ' ' .$semester; ?>
                                </td>
                            </tr>
                            <?php
                            // Update the current group
                            $currentSchoolYear = $schoolYear;
                            $currentSemester = $semester;
                        endif; ?>
                        <tr>
                        <td data-cell="User Id"><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td data-cell="Name"><?php echo htmlspecialchars(ucwords($row['name'])); ?></td>
                        <td data-cell="Ticket No"><?php echo htmlspecialchars($row['ticket_no']); ?></td>
                        <td data-cell="Room No"><?php echo htmlspecialchars($row['room_id']); ?></td>
                        <td data-cell="Description"><?php echo htmlspecialchars(ucwords($row['description'])); ?></td>
                        <td data-cell="Time Needed"><?php echo $formattedTime; ?></td>
                        <td data-cell="Time End"><?php echo $formattedTimeEnd; ?></td>
                        <td data-cell="Date Needed"><?php echo $formattedDate; ?></td>
                        <td data-cell="Status"><?php echo htmlspecialchars(ucwords($row['status'])); ?></td>
                        <td data-cell="Feedback"><?php echo htmlspecialchars(ucwords($row['feedback'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
</div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
            // Get references to the Print and Search buttons
            const printButton = document.getElementById("printButton");
            const searchInput = document.getElementById("searchInput");
            const searchButton = document.getElementById("searchButton");
            const tableBody = document.querySelector("#reportTable tbody");

            // Function to handle printing the table
            printButton.addEventListener("click", function () {
            const printWindow = window.open('', '_blank'); // Open a new window or tab

            // Construct the HTML content for the new window
            const printContent = `
                <html>
                <head>
                    <title>Print Report</title>
                    <link rel="stylesheet" type="text/css" href="print.css">
                </head>
                <body style="margin: 20px;">
                    <div class="table-container">
                        <table id="reportTable">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Name</th>
                                    <th>Ticket No.</th>
                                    <th>Room</th>
                                    <th>Description</th>
                                    <th>Time Needed</th>
                                    <th>Time End</th>
                                    <th>Date Needed</th>
                                    <th>Status</th>
                                    <th>Feedback</th>   
                                </tr>
                            </thead>
                            <tbody>
                                ${tableBody.innerHTML}
                            </tbody>
                        </table>
                    </div>
                </body>
                </html>
            `;

            // Write the HTML content to the new window
            printWindow.document.open();
            printWindow.document.write(printContent);
            printWindow.document.close();

            // Wait for content to load before printing
            printWindow.onload = function () {
                printWindow.print();
            };
        });

            // Function to handle table search
            searchButton.addEventListener("click", function () {
                const searchTerm = searchInput.value.toLowerCase();
                const rows = tableBody.querySelectorAll("tr");

                rows.forEach(function (row) {
                    const columns = row.querySelectorAll("td");
                    let rowMatch = false;

                    columns.forEach(function (column) {
                        const cellText = column.textContent.toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            rowMatch = true;
                        }
                    });

                    if (rowMatch) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });
    </script>

