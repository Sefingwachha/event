<?php
// dashboard.php (The new private dashboard for regular users)
require_once 'db.php';
include 'templates/header.php';

// Authentication check
if (!$is_loggedin) {
    header("location: /event-management-system/index.php"); // Redirect to the new landing page
    exit;
}

// If an admin somehow lands here, send them to their own dashboard
if ($is_admin) {
    header("location: /event-management-system/admin/index.php");
    exit;
}
?>

<h2>
    <i class='bx bxs-home'></i> Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!
</h2>
<p>This is your personal dashboard. You can view company events, see attendee lists, and learn more about the platform using the navigation menu.</p>

<div class="user-quick-links">
    <a href="/event-management-system/events/list.php" class="quick-link-card">
        <i class='bx bxs-calendar'></i>
        <span>View Events</span>
    </a>
    <a href="/event-management-system/attendees/list.php" class="quick-link-card">
        <i class='bx bxs-group'></i>
        <span>View Attendees</span>
    </a>
    <a href="/event-management-system/about.php" class="quick-link-card">
        <i class='bx bxs-info-circle'></i>
        <span>About Us</span>
    </a>
    <a href="/event-management-system/contact.php" class="quick-link-card">
        <i class='bx bxs-paper-plane'></i>
        <span>Contact</span>
    </a>
</div>

<?php include 'templates/footer.php'; ?>
