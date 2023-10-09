<?php
require_once '../config/db_connect.php';
require_once '../models/User.php';
require_once '../controllers/UserController.php';

if (isset($_POST['submit'])) {
    header('Location: ' . auth());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/src/css/bootstrap.min.css">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-success" name="submit">Login</button>
                <p>Ngga ada akun? <a href="register.php">bikin akun</a></p>
            </div>
        </form>
    </div>
</body>

</html>