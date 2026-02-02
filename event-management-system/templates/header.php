<?php
// templates/header.php (Final Correct Version)

// Start the session if it's not already started. This is safe to run on every page.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set convenient boolean variables to check login status and role.
$is_loggedin = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$is_admin = $is_loggedin && isset($_SESSION["role"]) && $_SESSION["role"] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayojan Pro</title>
    
    <!-- Fonts and Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="/event-management-system/css/style.css">
</head>
<body>

<?php // This entire private layout (sidebar + main content) will ONLY be rendered if the user is logged in. ?>
<?php if ($is_loggedin): ?>
    <div class="app-layout">
        <aside class="sidebar">
            <div class="sidebar-header">
                <?php // This dynamic link points the logo to the correct dashboard based on the user's role. ?>
                <a href="<?php echo $is_admin ? '/event-management-system/admin/index.php' : '/event-management-system/dashboard.php'; ?>" class="logo">
                    <i class='bx bxs-calendar-star'></i>
                    <span>Ayojan Pro</span>
                </a>
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <?php // The first navigation link is also dynamic based on the user's role. ?>
                    <?php if ($is_admin): ?>
                        <li><a href="/event-management-system/admin/index.php"><i class='bx bxs-dashboard'></i> <span>Admin Dashboard</span></a></li>
                    <?php else: ?>
                        <li><a href="/event-management-system/dashboard.php"><i class='bx bxs-home'></i> <span>Home</span></a></li>
                    <?php endif; ?>

                    <?php // These links are the same for all logged-in users. ?>
                    <li><a href="/event-management-system/events/list.php"><i class='bx bxs-calendar'></i> <span>Events</span></a></li>
                    <li><a href="/event-management-system/attendees/list.php"><i class='bx bxs-group'></i> <span>Attendees</span></a></li>
                    <li><a href="/event-management-system/about.php"><i class='bx bxs-info-circle'></i> <span>About</span></a></li>
                    <li><a href="/event-management-system/contact.php"><i class='bx bxs-paper-plane'></i> <span>Contact</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <div class="user-info">
                    <span class="username"><?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                    <span class="role"><?php echo htmlspecialchars($_SESSION["role"]); ?></span>
                </div>
                <a href="/event-management-system/auth/logout.php" class="logout-btn" title="Logout">
                    <i class='bx bx-log-out'></i>
                </a>
            </div>
        </aside>
        <main class="main-content">
            <header class="main-header">
                <div class="dark-mode-toggle" id="darkModeToggle" title="Toggle Dark Mode">
                    <i class='bx bx-moon'></i><i class='bx bx-sun'></i>
                </div>
            </header>
            <div class="content-wrapper">
<?php endif; ?>
<?php // If a user is not logged in, this file produces no HTML output. The landing page (index.php) handles its own structure. ?>
