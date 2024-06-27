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


$taskId = $_GET['id'] ?? null;

$sql = "SELECT * FROM tasks WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo "SQL statement preparation failed: " . $conn->error;
} else {
    $stmt->bind_param("i", $taskId); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
    } else {
        echo "No task found with ID: " . $taskId;
        exit();
    }

    $stmt->close();
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center">
            <h1>Edit Task</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="update.php" method="POST">
                    <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($task['id']); ?>">
                    
                    <div class="form-group">
                        <label for="task_name">Task Name</label>
                        <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="task_description">Description</label>
                        <textarea class="form-control" id="task_description" name="task_description" rows="3"><?php echo htmlspecialchars($task['task_description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="In Progress" <?php if ($task['status'] === 'incomplete') echo 'selected'; ?>>I</option>
                            <option value="Completed" <?php if ($task['status'] === 'completed') echo 'selected'; ?>>C</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="due_date">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo htmlspecialchars($task['due_date']); ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Task</button>
                    <a href="adminsdashboard.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
