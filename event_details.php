<?php include 'db.php'; ?>

<?php
$event_id = $_GET['id'];
$event_sql = "SELECT * FROM events WHERE id = $event_id";
$event_result = $conn->query($event_sql);
$event = $event_result->fetch_assoc();

$participants_sql = "SELECT * FROM participants WHERE event_id = $event_id";
$participants_result = $conn->query($participants_sql);
?>

<h1><?php echo $event['name']; ?></h1>
<p>Date: <?php echo $event['date']; ?></p>
<p>Time: <?php echo $event['time']; ?></p>
<p>Venue: <?php echo $event['venue']; ?></p>
<p>Organizer: <?php echo $event['organizer']; ?></p>
<p>Description: <?php echo $event['description']; ?></p>

<h2>Participants</h2>
<table border="1">
    <tr>
        <th>Name</th>
        <th>Role</th>
        <th>Contact</th>
    </tr>
    <?php while ($row = $participants_result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['role']; ?></td>
            <td><?php echo $row['contact']; ?></td>
        </tr>
    <?php } ?>
</table>
