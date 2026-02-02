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
// events/update.php
// Handles updating an existing event's details.

require_once '../db.php';

// Initialize variables
$name = $description = $location = $event_date = "";
$id = 0;
$errors = [];

// Check if an ID is provided in the URL (GET request) to load event data
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    $id = trim($_GET["id"]);
    
    // Prepare a select statement to fetch the event
    $sql = "SELECT * FROM events WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $param_id);
        $param_id = $id;
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                // Populate form fields with data from the database
                $name = $row["name"];
                $description = $row["description"];
                $location = $row["location"];
                $event_date = $row["event_date"];
            } else {
                // If no event found with that ID, redirect
                header("location: list.php");
                exit();
            }
        }
        $stmt->close();
    }
}

// Process form data when the form is submitted (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get hidden ID value from the form
    $id = $_POST["id"];

    // --- Input Validation ---
    if (empty(trim($_POST["name"]))) {
        $errors[] = "Name is required.";
    } else {
        $name = trim($_POST["name"]);
    }
    
    if (empty(trim($_POST["location"]))) {
        $errors[] = "Location is required.";
    } else {
        $location = trim($_POST["location"]);
    }

    if (empty($_POST["event_date"])) {
        $errors[] = "Event date is required.";
    } else {
        $event_date = $_POST["event_date"];
    }

    $description = trim($_POST["description"]);

    // If there are no errors, update the database
    if (empty($errors)) {
        $sql = "UPDATE events SET name = ?, description = ?, location = ?, event_date = ? WHERE id = ?";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssi", $param_name, $param_desc, $param_loc, $param_date, $param_id);
            
            $param_name = $name;
            $param_desc = $description;
            $param_loc = $location;
            $param_date = $event_date;
            $param_id = $id;
            
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

// Include header for HTML output
include '../templates/header.php';
?>

<h2>Update Event</h2>

<!-- Display validation errors -->
<?php if(!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- The update form -->
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
    
    <label>Event Name:</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
    
    <label>Description:</label>
    <textarea name="description"><?php echo htmlspecialchars($description); ?></textarea>
    
    <label>Location:</label>
    <input type="text" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
    
    <label>Event Date:</label>
    <input type="date" name="event_date" value="<?php echo htmlspecialchars($event_date); ?>" required>
    
    <input type="submit" value="Update Event" class="btn">
    <a href="list.php" class="btn btn-danger">Cancel</a>
</form>

<?php
include '../templates/footer.php';
?>
