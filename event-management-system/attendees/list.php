<?php
// attendees/list.php

// Connect to DB and load the header template
require_once '../db.php';
include '../templates/header.php';

// Security Check: If a user is not logged in, send them to the login page.
if (!$is_loggedin) {
    header("location: /event-management-system/auth/login.php");
    exit;
}
?>

<h2>
    <i class='bx bxs-group'></i> Manage Attendees
</h2>

<?php // This "Add" button will ONLY be visible to admins ?>
<?php if ($is_admin): ?>
    <a href="create.php" class="btn">
        <i class='bx bx-plus'></i> Add New Attendee
    </a>
<?php endif; ?>

<input type="text" id="attendeeSearch" onkeyup="searchAttendees()" placeholder="Search for attendees by name or email..." class="search-box">

<div class="table-wrapper">
    <table id="attendeeTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Event Name</th>
                <?php // The "Actions" column header ONLY appears for admins ?>
                <?php if ($is_admin) echo "<th>Actions</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // **DIFFERENCE 1: THE SQL QUERY**
            // This query uses a JOIN to combine data from the `attendees` table (aliased as 'a')
            // and the `events` table (aliased as 'e').
            $sql = "SELECT a.id, a.name, a.email, a.phone, e.name AS event_name 
                    FROM attendees a 
                    LEFT JOIN events e ON a.event_id = e.id
                    ORDER BY a.id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php // **DIFFERENCE 2: THE DATA DISPLAYED** ?>
                        <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td data-label="Email"><?php echo htmlspecialchars($row['email']); ?></td>
                        <td data-label="Phone"><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td data-label="Event Name"><?php echo htmlspecialchars($row['event_name']); ?></td>
                        
                        <?php // The "Actions" column data ONLY appears for admins ?>
                        <?php if ($is_admin): ?>
                            <td data-label="Actions">
                                <?php // **DIFFERENCE 3: THE LINKS** ?>
                                <?php // These links point to files inside the /attendees/ folder ?>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn" title="Edit"><i class='bx bxs-edit'></i></a> 
                                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger" title="Delete"><i class='bx bxs-trash'></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile;
            else:
                $colspan = $is_admin ? 5 : 4;
                echo "<tr><td colspan='{$colspan}'>No attendees found.</td></tr>";
            endif;
            
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php
include '../templates/footer.php';
?>
