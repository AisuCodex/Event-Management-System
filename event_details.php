<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php
        $event_id = $_GET['id'];
        $event_sql = "SELECT * FROM events WHERE id = $event_id";
        $event_result = $conn->query($event_sql);
        $event = $event_result->fetch_assoc();

        $participants_sql = "SELECT * FROM participants WHERE event_id = $event_id";
        $participants_result = $conn->query($participants_sql);
        ?>
        <h1 class="mb-4"><?php echo $event['name']; ?></h1>
        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Date:</strong> <?php echo $event['date']; ?></p>
                <p><strong>Time:</strong> <?php echo date('h:i A', strtotime($event['time'])); ?></p>
                <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
                <p><strong>Organizer:</strong> <?php echo $event['organizer']; ?></p>
                <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
            </div>
        </div>

        <h2 class="mb-3">Participants</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $participants_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td>
                                <a href="edit_participant.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                <a href="delete_participant.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this participant?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            <a href="add_participant.php?event_id=<?php echo $event_id; ?>" class="btn btn-primary">Add Participant</a>
            <a href="index.php" class="btn btn-secondary">Back to Events</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>