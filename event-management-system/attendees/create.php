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
// attendees/create.php
// Handles creating a new attendee for an event.

require_once '../db.php';
include '../templates/header.php';

$name = $email = $phone = $event_id = "";
$errors = [];

// Fetch events to populate the dropdown
$events_result = $conn->query("SELECT id, name FROM events ORDER BY name");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- Input Validation ---
    if (empty(trim($_POST["name"]))) {
        $errors[] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    // Validate email
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

    $phone = trim($_POST["phone"]); // Phone is optional

    if (empty($errors)) {
        $sql = "INSERT INTO attendees (name, email, phone, event_id) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssi", $param_name, $param_email, $param_phone, $param_event_id);
            
            $param_name = $name;
            $param_email = $email;
            $param_phone = $phone;
            $param_event_id = $event_id;
            
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
?>

<h2>Add New Attendee</h2>

<?php if(!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            while ($event = $events_result->fetch_assoc()) {
                // Determine if this option should be selected (for form resubmission)
                $selected = ($event['id'] == $event_id) ? 'selected' : '';
                echo "<option value='" . $event['id'] . "' " . $selected . ">" . htmlspecialchars($event['name']) . "</option>";
            }
        }
        ?>
    </select>
    
    <input type="submit" value="Add Attendee" class="btn">
</form>

<?php
include '../templates/footer.php';
?>
