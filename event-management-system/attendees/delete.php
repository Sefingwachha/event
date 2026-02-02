<?php
// --- Admin-Only Access Check ---
session_start();

// If the user is not logged in OR if their role is not 'admin'
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'admin') {
    // Immediately stop the script and redirect them away.
    header("location: /event-management-system/index.php");
    exit;
}

// --- If the script reaches this point, the user IS an admin ---
// The rest of the file's code (e.g., database deletion logic) comes after this.
?>

<?php
// attendees/delete.php
// Handles the deletion of an attendee.

require_once '../db.php';

if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $sql = "DELETE FROM attendees WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = trim($_GET["id"]);
        
        if ($stmt->execute()) {
            header("location: list.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    $stmt->close();
    $conn->close();
} else {
    header("location: list.php");
    exit();
}
?>
