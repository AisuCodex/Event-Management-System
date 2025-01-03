<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .create-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
        }
        .search-container {
            margin: 20px 0;
        }
        .search-input {
            padding: 8px;
            width: 300px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .search-btn {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .highlight {
            background-color: yellow;
            padding: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Event Management System</h1>
            
        </div>

        <div class="search-container">
            <form method="GET" action="">
                <input type="text" name="search" class="search-input" placeholder="Search events..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="search-btn">Search</button> <br> <br>
                <a href="create_event.php" class="create-btn">Create New Event</a>
            </form>
        </div>
        
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Actions</th>
            </tr>
            <?php
            include 'db.php';
            
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            
            if ($search) {
                $search = "%{$search}%";
                $sql = "SELECT * FROM events WHERE 
                        name LIKE ? OR 
                        venue LIKE ? OR 
                        date LIKE ? OR 
                        time LIKE ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $search, $search, $search, $search);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                $sql = "SELECT * FROM events";
                $result = $conn->query($sql);
            }
            
            function highlightText($text, $search) {
                if ($search && !empty($search)) {
                    $search = str_replace(['%'], '', $search);
                    return preg_replace("/($search)/i", '<span class="highlight">$1</span>', $text);
                }
                return $text;
            }
            
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>" . highlightText($row['name'], $search) . "</td>
                            <td>" . highlightText($row['date'], $search) . "</td>
                            <td>" . highlightText(date('h:i A', strtotime($row['time'])), $search) . "</td>
                            <td>" . highlightText($row['venue'], $search) . "</td>
                            <td>
                                <a href='event_details.php?id={$row['id']}'>View</a> | 
                                <a href='update_event.php?id={$row['id']}'>Edit</a> | 
                                <a href='delete_event.php?id={$row['id']}' onclick='return confirm(\"Are you sure?\");'>Delete</a>
                            </td>
                        </tr>";
                }
                if ($search) {
                    $stmt->close();
                }
                $result->close();
            }
            $conn->close();
            ?>
        </table>
    </div>
</body>
</html>