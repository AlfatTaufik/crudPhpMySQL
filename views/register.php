<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../src/css/bootstrap.min.css">
    <link rel="stylesheet" href="../public/src/css/bootstrap.min.css">
</head>

<body>
    <div class="d-flex align-items-center justify-content-center" style="height: 100vh;">
        <form action="../controllers/CreateUserController.php" method="POST">
            <div>
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <div>
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mt-2">
                <button type="submit" class="btn btn-primary" name="register">Register</button>
                <p>Punya akun? <a href="login.php">login sekarang</a></p>
            </div>
        </form>
    </div>
</body>

</html>