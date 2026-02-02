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
// events/create.php
// Handles the creation of a new event.

// Include database connection and header
require_once '../db.php';
include '../templates/header.php';

// Initialize variables for form fields
$name = $description = $location = $event_date = "";
$errors = [];

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- Input Validation ---
    // Name: required, trim whitespace
    if (empty(trim($_POST["name"]))) {
        $errors[] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    // Location: required, trim whitespace
    if (empty(trim($_POST["location"]))) {
        $errors[] = "Location is required.";
    } else {
        $location = trim($_POST["location"]);
    }

    // Event Date: required
    if (empty($_POST["event_date"])) {
        $errors[] = "Event date is required.";
    } else {
        $event_date = $_POST["event_date"];
    }

    // Description is optional
    $description = trim($_POST["description"]);

    // If there are no validation errors, proceed to insert into the database
    if (empty($errors)) {
        // Prepare an SQL statement to prevent SQL injection
        $sql = "INSERT INTO events (name, description, location, event_date) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_name, $param_desc, $param_loc, $param_date);
            
            // Set parameters
            $param_name = $name;
            $param_desc = $description;
            $param_loc = $location;
            $param_date = $event_date;
            
            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to the event list page on success
                header("location: list.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>

<h2>Create New Event</h2>

<!-- Display validation errors if any -->
<?php if(!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Event creation form -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="name">Event Name:</label>
    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($name); ?>" required>
    
    <label for="description">Description:</label>
    <textarea name="description" id="description"><?php echo htmlspecialchars($description); ?></textarea>
    
    <label for="location">Location:</label>
    <input type="text" name="location" id="location" value="<?php echo htmlspecialchars($location); ?>" required>
    
    <label for="event_date">Event Date:</label>
    <input type="date" name="event_date" id="event_date" value="<?php echo htmlspecialchars($event_date); ?>" required>
    
    <input type="submit" value="Create Event" class="btn">
</form>

<?php
// Include footer
include '../templates/footer.php';
?>
