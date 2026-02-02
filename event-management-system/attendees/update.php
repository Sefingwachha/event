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
// attendees/update.php
// Handles updating an existing attendee's details.

require_once '../db.php';

$name = $email = $phone = $event_id = "";
$id = 0;
$errors = [];

// Fetch all events for the dropdown
$events_result = $conn->query("SELECT id, name FROM events ORDER BY name");

// Get attendee data for the form on page load
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    
    $sql = "SELECT * FROM attendees WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $name = $row["name"];
                $email = $row["email"];
                $phone = $row["phone"];
                $event_id = $row["event_id"];
            } else {
                header("location: list.php");
                exit();
            }
        }
        $stmt->close();
    }
}

// Process form data on submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];

    if (empty(trim($_POST["name"]))) {
        $errors[] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    if (empty(trim($_POST["email"]))) {
        $errors[] = "Email is required.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    } else {
        $email = trim($_POST["email"]);
    }

    if (empty($_POST["event_id"])) {
        $errors[] = "Please select an event.";
    } else {
        $event_id = $_POST["event_id"];
    }

    $phone = trim($_POST["phone"]);

    if (empty($errors)) {
        $sql = "UPDATE attendees SET name = ?, email = ?, phone = ?, event_id = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssii", $name, $email, $phone, $event_id, $id);
            
            if ($stmt->execute()) {
                header("location: list.php");
                exit();
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

<h2>Update Attendee</h2>

<?php if(!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    
    <label>Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    
    <label>Email:</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
    
    <label>Phone:</label>
    <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
    
    <label>Event:</label>
    <select name="event_id" required>
        <option value="">-- Select an Event --</option>
        <?php
        if ($events_result->num_rows > 0) {
            // Reset pointer to the beginning of the result set
            $events_result->data_seek(0); 
            while ($event = $events_result->fetch_assoc()) {
                $selected = ($event['id'] == $event_id) ? 'selected' : '';
                echo "<option value='" . $event['id'] . "' " . $selected . ">" . htmlspecialchars($event['name']) . "</option>";
            }
        }
        ?>
    </select>
    
    <input type="submit" value="Update Attendee" class="btn">
    <a href="list.php" class="btn btn-danger">Cancel</a>
</form>

<?php
include '../templates/footer.php';
?>
