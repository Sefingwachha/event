<?php
// admin/index.php (Admin Panel Dashboard)

// --- Admin-Only Access Check ---
require_once '../db.php';
include '../templates/header.php';

// This check is now in the header, but an extra layer here is good practice.
if (!$is_admin) {
    header("location: /event-management-system/index.php");
    exit;
}

// --- Fetch Statistics for the Dashboard ---

// 1. Total Events
$total_events_result = $conn->query("SELECT COUNT(*) as total FROM events");
$total_events = $total_events_result->fetch_assoc()['total'];

// 2. Total Attendees
$total_attendees_result = $conn->query("SELECT COUNT(*) as total FROM attendees");
$total_attendees = $total_attendees_result->fetch_assoc()['total'];

// 3. Upcoming Events
$upcoming_events_result = $conn->query("SELECT COUNT(*) as total FROM events WHERE event_date >= CURDATE()");
$upcoming_events = $upcoming_events_result->fetch_assoc()['total'];

// 4. Most Recent Attendees
$recent_attendees_result = $conn->query("
    SELECT a.name as attendee_name, a.email, e.name as event_name 
    FROM attendees a 
    JOIN events e ON a.event_id = e.id 
    ORDER BY a.id DESC 
    LIMIT 5
");

?>

<div class="admin-dashboard">
    <h2>
        <i class='bx bxs-dashboard'></i> Admin Dashboard
    </h2>

    <!-- Stat Cards -->
    <div class="stat-cards-container">
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0f2fe;">
                <i class='bx bxs-calendar' style="color: #0ea5e9;"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number"><?php echo $total_events; ?></span>
                <span class="stat-label">Total Events</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7;">
                <i class='bx bxs-group' style="color: #22c55e;"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number"><?php echo $total_attendees; ?></span>
                <span class="stat-label">Total Attendees</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fefce8;">
                <i class='bx bxs-time-five' style="color: #eab308;"></i>
            </div>
            <div class="stat-info">
                <span class="stat-number"><?php echo $upcoming_events; ?></span>
                <span class="stat-label">Upcoming Events</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="card recent-activity">
        <h3><i class='bx bx-history'></i> Recent Attendee Registrations</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Attendee Name</th>
                        <th>Email</th>
                        <th>Registered For Event</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_attendees_result->num_rows > 0): ?>
                        <?php while($row = $recent_attendees_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['attendee_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No recent activity.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php
$conn->close();
include '../templates/footer.php';
?>
