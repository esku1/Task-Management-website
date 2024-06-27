<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - User Dashboard</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .sidebar {
            width: 250px;
            height: 100%;
            background-color: #2A415F;
            padding: 15px;
            position: fixed;
            overflow-y: auto; 
            transition: all 0.3s;
        }
        .sidebar h4 {
            color: #ffffff; 
            margin-top: 50px;
            margin-bottom: 20px;
        }
        .sidebar .divider {
            width: 100%;
            height: 1px;
            background-color: #ffffff; 
            margin-top: 50px;
            margin-bottom: 20px;
        }
        .sidebar ul.nav {
            list-style-type: none;
            padding: 0;
            margin-top: 20px; 
        }
        .sidebar ul.nav li.nav-item a.nav-link {
            color: #ffffff; 
            padding: 10px;
            transition: all 0.3s;
            border-radius: 5px;
        }
        .sidebar ul.nav li.nav-item a.nav-link:hover,
        .sidebar ul.nav li.nav-item a.nav-link.active {
            background-color: #ffffff; 
            color: #343a40; 
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            background-color: #ffffff; 
        .content h1 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .content p {
            color: #6c757d; 
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?></h4>
    <div class="divider"></div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link<?php echo isset($_GET['page']) && $_GET['page'] === 'uhome' ? ' active' : ''; ?>" href="usersdashboard.php?page=uhome">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php echo isset($_GET['page']) && $_GET['page'] === 'uviewtask' ? ' active' : ''; ?>" href="usersdashboard.php?page=uviewtask">View Task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link<?php echo isset($_GET['page']) && $_GET['page'] === 'uaddtask' ? ' active' : ''; ?>" href="usersdashboard.php?page=uaddtask">Add Task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.php">Logout</a>
        </li>
    </ul>
</div>

<div class="content">
    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        switch ($page) {
            case 'uhome':
                include('uhome.php');
                break;
            case 'uviewtask':
                include('uviewtask.php');
                break;
            case 'uaddtask':
                include('uaddtask.php');
                break;
            default:
                include('uhome.php');
                break;
        }
    } else {
        include('uhome.php');
    }
    ?>
</div>

</body>
</html>
