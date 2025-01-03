<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO participants (event_id, name, role, contact) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $event_id, $name, $role, $contact);

    if ($stmt->execute()) {
        header("Location: event_details.php?id=" . $event_id);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$event_id = $_GET['event_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Participant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Participant</h2>
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <input type="text" class="form-control" id="role" name="role" required>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Participant</button>
                    <a href="event_details.php?id=<?php echo $event_id; ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
