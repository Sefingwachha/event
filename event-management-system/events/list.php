<?php
// events/list.php

// Connect to DB and load the header template
require_once '../db.php';
include '../templates/header.php';

// Security Check: The $is_loggedin and $is_admin variables are set in header.php.
// If a user is not logged in at all, send them to the login page.
if (!$is_loggedin) {
    header("location: /event-management-system/auth/login.php");
    exit;
}
?>

<h2>
    <i class='bx bxs-calendar'></i> Manage Events
</h2>

<?php // This "Add" button will ONLY be visible to admins ?>
<?php if ($is_admin): ?>
    <a href="create.php" class="btn">
        <i class='bx bx-plus'></i> Add New Event
    </a>
<?php endif; ?>

<input type="text" id="eventSearch" onkeyup="searchEvents()" placeholder="Search for events by name or location..." class="search-box">

<div class="table-wrapper">
    <table id="eventTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Location</th>
                <th>Date</th>
                <?php // The "Actions" column header ONLY appears for admins ?>
                <?php if ($is_admin) echo "<th>Actions</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            // **DIFFERENCE 1: THE SQL QUERY**
            // This query selects ONLY from the `events` table.
            $sql = "SELECT id, name, description, location, event_date FROM events ORDER BY event_date DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php // **DIFFERENCE 2: THE DATA DISPLAYED** ?>
                        <td data-label="Name"><?php echo htmlspecialchars($row['name']); ?></td>
                        <td data-label="Description"><?php echo htmlspecialchars($row['description']); ?></td>
                        <td data-label="Location"><?php echo htmlspecialchars($row['location']); ?></td>
                        <td data-label="Date"><?php echo htmlspecialchars($row['event_date']); ?></td>
                        
                        <?php // The "Actions" column data ONLY appears for admins ?>
                        <?php if ($is_admin): ?>
                            <td data-label="Actions">
                                <?php // **DIFFERENCE 3: THE LINKS** ?>
                                <?php // These links point to files inside the /events/ folder ?>
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn" title="Edit"><i class='bx bxs-edit'></i></a> 
                                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');" class="btn btn-danger" title="Delete"><i class='bx bxs-trash'></i></a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile;
            else:
                $colspan = $is_admin ? 5 : 4;
                echo "<tr><td colspan='{$colspan}'>No events found.</td></tr>";
            endif;
            
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

<?php
include '../templates/footer.php';
?>
