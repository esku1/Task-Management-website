<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Member Account</title>
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
            <h1>Create a New Member Account</h1>
            <p class="lead">Fill in the details below to create a new member account</p>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Member Details</h5>
            </div>
            <div class="card-body">
                <form action="save_member.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="memberFirstname">First Name</label>
                        <input type="text" class="form-control" id="memberFirstname" name="memberFirstname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="memberLastname">Last Name</label>
                        <input type="text" class="form-control" id="memberLastname" name="memberLastname" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="memberUsername">Username</label>
                        <input type="text" class="form-control" id="memberUsername" name="memberUsername" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="memberEmail">Email</label>
                        <input type="email" class="form-control" id="memberEmail" name="memberEmail" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="memberPassword">Password</label>
                        <input type="password" class="form-control" id="memberPassword" name="memberPassword" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Account</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
