<?php
// auth/register.php
require_once '../db.php';

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Check if username is already taken
        $sql = "SELECT id FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $param_username);
            $param_username = trim($_POST["username"]);
            if ($stmt->execute()) {
                $stmt->store_result();
                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // If no errors, insert into database
    if (empty($username_err) && empty($password_err)) {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_username, $param_password);
            
            $param_username = $username;
            // Hash the password for security
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("location: login.php");
            } else {
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }
    $conn->close();
}
include '../templates/header.php';
?>

<h2>Register</h2>
<p>Create an account to view events and attendees.</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div>
        <label>Username</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
        <span style="color:red;"><?php echo $username_err; ?></span>
    </div>    
    <div>
        <label>Password</label>
        <input type="password" name="password">
        <span style="color:red;"><?php echo $password_err; ?></span>
    </div>
    <div>
        <input type="submit" class="btn" value="Register">
    </div>
    <p>Already have an account? <a href="login.php">Login here</a>.</p>
</form>

<?php include '../templates/footer.php'; ?>
