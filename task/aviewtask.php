<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "esku";
$dbname = "taskmgt";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View All Tasks</title>
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
        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #ffffff;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #ffffff;
        }
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
    <script>
function deleteTask(taskId) {
    if (confirm("Are you sure you want to delete this task?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                alert("Task deleted successfully");
                location.reload();
            }
        };
        xhttp.open("GET", "delete_task.php?id=" + taskId, true);
        xhttp.send();
    }
}
</script>
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center">
            <h1>All Tasks</h1>
            <p class="lead">Here are all the tasks in the system</p>
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
                                <th>Assigned To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT tasks.id, tasks.task_name, tasks.task_description, tasks.status, tasks.due_date, users.firstname as assigned_to 
                                    FROM tasks 
                                    JOIN users ON tasks.user_id = users.id";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['due_date']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['assigned_to']) . "</td>";
                                    echo '<td>
                                    <a href="edit.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-edit btn-sm">Edit</a>
                                    <a href="delete_task.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-delete btn-sm">Delete</a>
                                  </td>';
                                    echo "</tr>";
                                }
                            } else {
                                echo '<tr><td colspan="7">No tasks found</td></tr>';
                            }
                            mysqli_close($conn);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
