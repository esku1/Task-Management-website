<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "esku";
$dbname = "taskmgt";

// Establishing connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape variables for security
    $firstname = $_POST['memberFirstname'];
    $lastname = $_POST['memberLastname'];
    $username = $_POST['memberUsername'];
    $email = $_POST['memberEmail'];
    $password = $_POST['memberPassword'];
    $role = 'user'; // Assuming new members are added as 'user' role

    // Check if username or email already exists
    $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Username or email already exists
        echo "Username or email already exists. Please choose a different username or email.";
        header("Location: admindashboard.php");

    } else {
        // SQL query to insert data into users table
        $insertSql = "INSERT INTO users (firstname, lastname, username, password, email, role)
                      VALUES (?, ?, ?, ?, ?, ?)";
        
        // Prepare and bind parameters
        $stmt = $conn->prepare($insertSql);
        $stmt->bind_param("ssssss", $firstname, $lastname, $username, $password, $email, $role);

        // Execute the statement
        if ($stmt->execute()) {
            echo "New member account created successfully!";
            // Redirect to admin dashboard or any other appropriate page after successful creation
            header("Location: admindashboard.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }

    // Close check statement and connection
    $checkStmt->close();
    $conn->close();
}
?>
