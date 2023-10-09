<?php
require_once '../../config/db_connect.php';
require_once '../../models/User.php';
require_once '../../controllers/UserController.php';

if (isset($_POST['hapus'])) {
    $id = (int)$_POST['hapus'];
    destroy($id);
}

if (!$_SESSION['token']) {
    header('Location: ../login.php');
} else {

    $datas = getAll("WHERE token=" . $_SESSION['token']);
    foreach ($datas as $data) {
        $username = $data['name'];
        $token = $data['token'];
        $role_id = $data['role_id'];
    }
    if ($role_id != 1) {
        if (!isset($_POST['logout'])) {
            header('Location: ../404.html');
        }
    }

    if (isset($_POST['logout'])) {
        logout($token);
        header('Location: ../' . auth());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../../public/src/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
</head>

<body>
    <div id="form-container"></div>
    <nav class="bg-dark-subtle d-flex justify-content-between px-3">
        <div>
            <h1 class="">Admin</h1>
        </div>
        <div class="">
            <div class="px-2 py-2">
                <form action="" method="POST">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="container py-3">
        <div class="content">
            <h1>User</h1>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Password</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = getAll("WHERE name!='Admin'");
                        $iteration = 1;
                        foreach ($data as $row) :
                            // if (isset($_POST['submit'])) destroy($row['id']);
                        ?>
                            <tr>
                                <th scope="row"><?= $iteration ?></th>
                                <td><?= $row['image'] ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['password'] ?></td>
                                <td><?= $row['status'] ?></td>
                                <td>
                                    <?php if ($row['status'] != 1) : ?>
                                        <button type="button" class="btn btn-danger" name="hapus" data-id="<?= $row['id'] ?>">Hapus</button>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <?php $iteration++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Menangani klik tombol "Hapus"
        let deleteButtons = document.querySelectorAll('button[name="hapus"]');
        let formContainer = document.getElementById('form-container');
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                let id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: 'Anda yakin ingin menghapus data ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        // Jika pengguna mengonfirmasi penghapusan
                        // Kirim form dengan ID sebagai nilai
                        var form = document.createElement('form');
                        form.action = '';
                        form.method = 'POST';

                        var input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'hapus';
                        input.value = id;

                        form.appendChild(input);
                        formContainer.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>

</body>

</html>