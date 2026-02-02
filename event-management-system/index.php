<?php
// index.php (The New Public Landing Page)

// Start the session to check login status and process login attempts
session_start();

// If a user is already logged in, redirect them to their appropriate dashboard immediately.
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    if ($_SESSION["role"] === 'admin') {
        header("location: /event-management-system/admin/index.php");
    } else {
        header("location: /event-management-system/dashboard.php"); // Redirect users to the new dashboard
    }
    exit;
}

// --- LOGIN PROCESSING LOGIC ---
// This code is moved here from auth/login.php
require_once 'db.php';
$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) { $username_err = "Please enter username."; } else { $username = trim($_POST["username"]); }
    if (empty(trim($_POST["password"]))) { $password_err = "Please enter your password."; } else { $password = trim($_POST["password"]); }
    
    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $stmt->bind_result($id, $db_username, $hashed_password, $role);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $db_username;
                            $_SESSION["role"] = $role;
                            
                            // Redirect based on role
                            if ($role === 'admin') {
                                header("location: /event-management-system/admin/index.php");
                            } else {
                                header("location: /event-management-system/dashboard.php"); // Updated redirect
                            }
                            exit;
                        } else { $login_err = "Invalid username or password."; }
                    }
                } else { $login_err = "Invalid username or password."; }
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ayojan Pro - Event Management by Saishan Gimire</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/event-management-system/css/style.css">
</head>
<body>
    <div class="landing-page">
        <!-- Header Section -->
        <header class="landing-header">
            <div class="landing-container">
                <a href="#" class="logo">
                    <i class='bx bxs-calendar-star'></i>
                    <span>Ayojan Pro</span>
                </a>
                <nav>
                    <a href="#features" class="nav-link">Features</a>
                    <a href="#about" class="nav-link">About</a>
                    <a href="#login-section" class="btn btn-primary">Login / Register</a>
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div class="landing-container">
                <h1>Organize Your Events, Seamlessly.</h1>
                <p class="subtitle">Welcome to Ayojan Pro (आयोजन प्रो), a modern event management solution proudly developed in Nepal by Saishan Gimire.</p>
                <a href="#login-section" class="btn btn-large">Get Started</a>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="features-section">
            <div class="landing-container">
                <h2>Why Choose Ayojan Pro?</h2>
                <div class="feature-cards">
                    <div class="feature-card">
                        <i class='bx bxs-user-check'></i>
                        <h3>Role-Based Access</h3>
                        <p>Secure separation between Admins who manage events and Users who can only view them.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bxs-dashboard'></i>
                        <h3>Admin Dashboard</h3>
                        <p>A powerful central hub for administrators to see key statistics and manage content with ease.</p>
                    </div>
                    <div class="feature-card">
                        <i class='bx bxs-devices'></i>
                        <h3>Modern & Responsive</h3>
                        <p>A beautiful, clean interface that works perfectly on desktops, tablets, and mobile devices.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Login Section -->
        <section id="login-section" class="login-section-landing">
            <div class="landing-container">
                <div class="public-card">
                    <div class="public-header">
                        <h2>Get Started</h2>
                        <p>Log in to access your dashboard.</p>
                    </div>
                    <?php if (!empty($login_err)) { echo '<div class="alert-danger">' . $login_err . '</div>'; } ?>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>#login-section" method="post">
                        <div class="form-group"><label>Username</label><input type="text" name="username"></div>
                        <div class="form-group"><label>Password</label><input type="password" name="password"></div>
                        <div class="form-group"><input type="submit" class="btn btn-full" value="Login"></div>
                        <p class="public-footer-text">Don't have an account? <a href="auth/register.php">Sign up now</a>.</p>
                    </form>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="about-section">
            <div class="landing-container">
                <div class="developer-card">
                    <h3>A Project by Saishan Gimire</h3>
                    <blockquote>
                        "Technology has the power to connect us. With Ayojan Pro, my goal was to create a tool that is not only powerful for administrators but also simple and welcoming for every user. It's a project built with a passion for clean code and a love for our community here in Nepal."
                    </blockquote>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="landing-footer">
            <p>&copy; <?php echo date("Y"); ?> Ayojan Pro by Saishan Gimire. All Rights Reserved.</p>
        </footer>
    </div>
</body>
</html>
