<?php
// auth/login.php (TEMPORARY BYPASS VERSION)
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once '../db.php';
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $db_username, $hashed_password, $role);
                $stmt->fetch();

                $login_success = false;

                // --- TEMPORARY BYPASS FOR BROKEN PHP ENVIRONMENT ---
                // This checks the password directly ONLY if the username is 'admin'.
                // This is NOT secure for a real website, but is necessary for this debug.
                if ($db_username === 'admin' && $password === 'password123') {
                    $login_success = true;
                    echo "<script>alert('NOTICE: Logged in using temporary admin bypass. Your PHP environment has an issue with password_verify(). Please see instructions to fix this permanently.');</script>";
                } 
                // We still check the normal way for other users
                elseif (password_verify($password, $hashed_password)) {
                    $login_success = true;
                }

                if ($login_success) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $db_username;
                    $_SESSION["role"] = $role;

                    if ($role === 'admin') {
                        header("location: /event-management-system/admin/index.php");
                    } else {
                        header("location: /event-management-system/index.php");
                    }
                    exit;
                } else {
                    $login_err = "Invalid username or password.";
                }
            } else {
                $login_err = "Invalid username or password.";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!-- The standard HTML form follows -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - EventMaster Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/event-management-system/css/style.css">
</head>
<body>
    <div class="public-layout">
        <main class="main-content-public">
            <div class="public-card">
                <div class="public-header">
                    <i class='bx bxs-calendar-star'></i><h1>Welcome to EventMaster</h1><p>Please log in to continue</p>
                </div>
                <?php if (!empty($login_err)) { echo '<div class="alert-danger">' . $login_err . '</div>'; } ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group"><label>Username</label><input type="text" name="username"></div>    
                    <div class="form-group"><label>Password</label><input type="password" name="password"></div>
                    <div class="form-group"><input type="submit" class="btn btn-full" value="Login"></div>
                    <p class="public-footer-text">Don't have an account? <a href="register.php">Sign up now</a>.</p>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
