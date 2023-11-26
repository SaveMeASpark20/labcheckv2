<?php
    session_start();
    if (!isset($_SESSION["admin"])) {
    header("Location: ../index.php");
    exit();
    }

$page = "User Registration";
include '../partial/admin_sidebar.php';
include '../partial/header.php';

 $schoolYear = $_SESSION['school_year'] ;
 $semester = $_SESSION['semester'];

require_once "../connection/database.php";

try {

    $sql = 'SELECT id, firstname, lastname, middlename, section, user_type
            FROM user_registration
            WHERE school_year = ? AND SEMESTER = ?
            ORDER BY created_at DESC';
    
    $stmt = $conn->prepare($sql);   
    $stmt->bind_param('ss', $schoolYear, $semester);
    $stmt->execute();
    $result = $stmt->get_result();

} catch (Exception $e) {
    die('Database error: ' . $e->getMessage());
}

require "NotificationManager.php";
$NotificationManager = new NotificationManager();
$notifications = $NotificationManager->getNotifications();
?>
<main class="user-reg-box">
    <?php foreach ($notifications as $notification) : ?>
        <?php if ($notification['type'] === 'success' && !empty($notification['message'])): ?>
            <div class="notification success">
                <p><?php echo htmlspecialchars($notification['message']); ?></p>
            </div>
            <?php endif; ?>

            <?php if ($notification['type'] === 'error' && !empty($notification['message'])): ?>
            <div class="notification error">
                <?php echo htmlspecialchars($notification['message']); ?>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
        <div class="filter-adduser">
            <form id="filterForm">
                <select id="userTypeFilter" name="userType">
                    <option value="all">All</option>
                    <option value="student">Student</option>
                    <option value="admin">Admin</option>
                    <option value="faculty">Faculty</option>
                </select>
            </form>

            <button id="showAddUserForm">Add User</button> 

            <?php
            include '../includes/adduser_form.php';
            ?>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr class="table-row-header">
                        <td>Last Name</td>
                        <td>First Name</td>
                        <td>Middle Name</td>
                        <td>ID</td>
                        <td class='hide-th'>Section</td>
                        <td>User Type</td>
                    </tr>
                </thead>
                <tbody id="userTable" class="table-body">
                    <!-- Table rows here -->    
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr data-user-type="<?php echo htmlspecialchars($row['user_type']); ?>">
                            <td data-cell="Lastname"><?php echo htmlspecialchars($row['lastname']); ?></td>
                            <td data-cell="Firstname"><?php echo htmlspecialchars($row['firstname']); ?></td>
                            <td data-cell="Middlename"><?php echo htmlspecialchars($row['middlename']); ?></td>
                            <td data-cell="ID"><?php echo htmlspecialchars($row['id']); ?></td>
                            <td data-cell="Section" id="user-section"><?php echo htmlspecialchars($row['section']); ?></td>
                            <td data-cell="User Type"><?php echo htmlspecialchars($row['user_type']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>   
</body>
</html>