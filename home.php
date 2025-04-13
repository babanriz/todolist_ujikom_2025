<?php
include "task.php";

if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // redirect ke login kalau belum login
    exit;
}

$order = 'due_date ASC';
if (isset($_POST['sort'])) {
    $order = $_POST['sort'] == 'latest' ? 'due_date DESC' : 'due_date ASC';
}

$result = get_user_tasks($koneksi, $order);

$task_data = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $task_data = get_task_by_id($koneksi, $id);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar dengan tombol burger dan logout -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">To-Do List</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="btn btn-danger" href="logout.php">Logout</a> <!-- Tombol Logout Merah -->
                </li>
            </ul>
        </div>
    </div>
    </nav>

    <!-- Pesan Selamat Datang di luar navbar -->
    <div class="container mt-4">
        <div class="row">
            <div class="col-12 text-center">
                <h4 class="text-dark">Selamat datang, <?= htmlspecialchars($_SESSION['username']) ?> 👋</h4>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Dashboard</h2>

        <!-- Form tambah/edit tugas -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="text-center"><?= $task_data ? 'Edit Tugas' : 'Tambah Tugas' ?></h4>
                <form method="POST" action="task.php">
                    <?php if ($task_data): ?>
                        <input type="hidden" name="id" value="<?= $task_data['id']; ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label">Nama Tugas</label>
                        <input type="text" name="task" class="form-control" required autofocus value="<?= $task_data ? $task_data['task'] : ''; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prioritas</label>
                        <select name="priority" class="form-select" required>
                            <option value="" disabled <?= !$task_data ? 'selected' : '' ?>>--Pilih Prioritas--</option>
                            <option value="1" <?= $task_data && $task_data['priority'] == 1 ? 'selected' : '' ?>>Tidak Penting</option>
                            <option value="2" <?= $task_data && $task_data['priority'] == 2 ? 'selected' : '' ?>>Penting</option>
                            <option value="3" <?= $task_data && $task_data['priority'] == 3 ? 'selected' : '' ?>>Sangat Penting</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="due_date" class="form-control" value="<?= $task_data ? $task_data['due_date'] : date('Y-m-d'); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" name="<?= $task_data ? 'update_task' : 'tabah_tugas'; ?>">
                        <?= $task_data ? 'Update Tugas' : 'Tambah Tugas'; ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Form urutkan -->
        <form method="POST" class="mb-4">
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Urutkan Tanggal</label>
                </div>
                <div class="col-md-6">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="oldest" <?= $order == 'due_date ASC' ? 'selected' : '' ?>>Dari Terlama</option>
                        <option value="latest" <?= $order == 'due_date DESC' ? 'selected' : '' ?>>Dari Terbaru</option>
                    </select>
                </div>
            </div>
        </form>

        <!-- Tabel daftar tugas -->
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Task</th>
                            <th>Prioritas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): $no = 1; ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['task'] ?></td>
                                    <td>
                                        <?php
                                            if ($row['priority'] == 1) echo "Tidak Penting";
                                            elseif ($row['priority'] == 2) echo "Penting";
                                            else echo "Sangat Penting";
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $due = strtotime($row['due_date']);
                                            $now = strtotime(date('Y-m-d'));
                                            $selisih = floor(($due - $now) / (60 * 60 * 24));
                                            echo $selisih > 0 ? "Sisa $selisih hari" :
                                                ($selisih == 0 ? "Hari ini" : "Telat " . abs($selisih) . " hari");
                                        ?>
                                    </td>
                                    <td><?= $row['status'] == 0 ? "Belum Selesai" : "Selesai" ?></td>
                                    <td>
                                        <?php if ($row['status'] == 0): ?>
                                            <a href="task.php?complete=<?= $row['id'] ?>" class="btn btn-success btn-sm">Selesai</a>
                                        <?php endif; ?>
                                        <a href="home.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="task.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Tidak ada tugas</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php include("asset/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
