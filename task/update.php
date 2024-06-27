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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $taskId = $_POST['task_id'];
    $taskName = $_POST['task_name'];
    $taskDescription = $_POST['task_description'];
    $status = $_POST['status'];
    $dueDate = $_POST['due_date'];

    if (strlen($status) > 255) { 
        die("Error: Status value exceeds maximum length.");
    }

    $sql = "UPDATE tasks SET task_name = ?, task_description = ?, status = ?, due_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "SQL statement preparation failed: " . $conn->error;
    } else {
        $stmt->bind_param("ssssi", $taskName, $taskDescription, $status, $dueDate, $taskId); // Assuming 'id' is an integer
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Redirect back to the view page
            header("Location: aviewtask.php");
            exit(); // Make sure to exit after a header redirect
        } else {
            echo "Failed to update task.";
        }

        $stmt->close();
    }
}

$conn->close();
?>
