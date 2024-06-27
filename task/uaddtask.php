<?php
    // session_start();
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $taskName = mysqli_real_escape_string($conn, $_POST['taskName']);
        $taskDescription = mysqli_real_escape_string($conn, $_POST['taskDescription']);
        $taskDueDate = mysqli_real_escape_string($conn, $_POST['taskDueDate']);
        $taskStatus = mysqli_real_escape_string($conn, $_POST['taskStatus']);
        
        $username = $_SESSION['username'];
        
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userId = $row['id'];

   
            $dateTime = DateTime::createFromFormat('Y-m-d', $taskDueDate);
            if ($dateTime) {
                $formattedDueDate = $dateTime->format('Y-m-d');
            } else {
                $formattedDueDate = null; 
            }

     
            $sql = "INSERT INTO tasks (user_id, task_name, task_description, status, due_date) VALUES ('$userId', '$taskName', '$taskDescription', '$taskStatus', '$formattedDueDate')";
            if ($conn->query($sql) === TRUE) {
                $message = "New task added successfully";
            } else {
                $message = "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            $message = "User not found.";
        }
    }

 
    ?>


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Dashboard - Add Task</title>
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
            .btn-primary {
                background-color: #2A415F;
                border-color: #2A415F;
            }
            .btn-primary:hover {
                background-color: #1f2e42;
                border-color: #1f2e42;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="header text-center">
                <h1>Add a New Task</h1>
                <p class="lead">Fill in the details below to add a new task</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Task Details</h5>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group mb-3">
                            <label for="taskName">Task Name</label>
                            <input type="text" class="form-control" id="taskName" name="taskName" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="taskDescription">Description</label>
                            <textarea class="form-control" id="taskDescription" name="taskDescription" rows="3" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="taskDueDate">Due Date</label>
                            <input type="date" class="form-control" id="taskDueDate" name="taskDueDate" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="taskStatus">Status</label>
                            <select class="form-control" id="taskStatus" name="taskStatus" required>
                                <option value="complete">complete</option>
                                <option value="Incomplete">incomplete</option>
                                
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Task</button>
                    </form>
                </div>
            </div>
        </div>

 </body>
    </html>