<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "esku";
$dbname = "taskmgt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $taskId = $_GET['id'];
    // Delete the task with the given ID
    $sql = "DELETE FROM tasks WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $taskId);
    if ($stmt->execute()) {
        
        $_SESSION['message'] = "Task deleted successfully";
    } else {
        $_SESSION['message'] = "Error deleting task: " . $conn->error;
    }
    $stmt->close();
}

$conn->close();

header("Location: admindashboard.php?page=aviewtask");
exit();
?>
