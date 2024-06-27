<?php
session_start();
$message = '';

$servername = "localhost";
$username = "root";
$password = "esku";
$dbname = "taskmgt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, CONCAT(firstname, ' ', lastname) AS fullname FROM users";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['taskbtn'])) {
    $taskName = mysqli_real_escape_string($conn, $_POST['taskName']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $dueDate = mysqli_real_escape_string($conn, $_POST['dueDate']);
    $assignedToFullName = mysqli_real_escape_string($conn, $_POST['assignedTo']);

    // Get the user ID based on the selected value
    $userId = $assignedToFullName;

    

    // Insert the task into the database
    $sql = "INSERT INTO tasks (user_id, task_name, task_description, status, due_date) VALUES ('$userId', '$taskName', '$description', '$status', '$dueDate')";
    if ($conn->query($sql) === TRUE) {
        $message = "New task added successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
//$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Add Task</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #2A415F;
            color: white;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center">
            <h1>Add Task</h1>
            <p class="lead">Enter task details below</p>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Task Details</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-primary" role="alert">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="taskName" class="form-label">Task Name</label>
                        <input type="text" class="form-control" id="taskName" name="taskName" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="incomplete">incomplete</option>
                            <option value="complete">complete</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="dueDate" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="dueDate" name="dueDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="assignedTo" class="form-label">Assigned To</label>
                        <select class="form-select" id="assignedTo" name="assignedTo" required>
                            <option selected disabled>Select member</option>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['fullname']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <button type="submit" name="taskbtn" class="btn btn-primary">Add Task</button>
                    <a href="aaddtask.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
