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
$sql = "SELECT firstname, email, username, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    echo "SQL statement preparation failed: " . $conn->error;
} else {
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($name, $email, $username, $joined);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #2A415F;
            color: white;
        }
        .card-body p {
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="header text-center">
            <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
            <p class="lead">Your Personal Information</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Personal Information</h5>
            </div>
            <div class="card-body">
                <ul class="info-list">
                    <li><strong>Name:</strong> <?php echo htmlspecialchars($name); ?></li>
                    <li><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></li>
                    <li><strong>Username:</strong> <?php echo htmlspecialchars($username); ?></li>
                    <li><strong>Joined:</strong> <?php echo htmlspecialchars($joined); ?></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
