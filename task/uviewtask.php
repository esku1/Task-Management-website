<?php
// session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "esku";
$dbname = "taskmgt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['user_id'];
$sqlTasks = "SELECT * FROM tasks WHERE user_id = ?";
$stmtTasks = $conn->prepare($sqlTasks);
if ($stmtTasks === false) {
    echo "SQL statement preparation failed: " . $conn->error;
} else {
    $stmtTasks->bind_param("i", $userId);
    $stmtTasks->execute();
    $result = $stmtTasks->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - View Tasks</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #2A415F;
            color: white;
        }
        .table thead th {
            background-color: #2A415F;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center">
            <h1>Your Tasks</h1>
            <p class="lead">Here are the tasks you need to manage</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Task List</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Task ID</th>
                                <th>Task Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo '<tr><td colspan="5">No tasks found for this user</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
$stmtTasks->close();
$conn->close();
?>
