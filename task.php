<?php
$koneksi = mysqli_connect("localhost", "root", "", "todo");

session_start();

// Login
if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = md5($_POST['password']);
    $q = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($q) > 0) {
        $data = mysqli_fetch_assoc($q);
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        header("Location: home.php");
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}

// Register
if (isset($_POST['register'])) {
    $u = $_POST['username'];
    $p = md5($_POST['password']);
    mysqli_query($koneksi, "INSERT INTO user (username, password) VALUES ('$u', '$p')");
    echo "<script>alert('Registrasi berhasil, silakan login'); location='index.php';</script>";
}

// Tambah Tugas
if (isset($_POST['tabah_tugas'])) {
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due = $_POST['due_date'];
    $uid = $_SESSION['user_id'];
    mysqli_query($koneksi, "INSERT INTO tasks (task, priority, due_date, user_id) VALUES ('$task','$priority','$due','$uid')");
    header("Location: home.php");
}

// Update Tugas
if (isset($_POST['update_task'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $priority = $_POST['priority'];
    $due = $_POST['due_date'];
    mysqli_query($koneksi, "UPDATE tasks SET task='$task', priority='$priority', due_date='$due' WHERE id=$id");
    header("Location: home.php");
}

// Tandai Selesai
if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    mysqli_query($koneksi, "UPDATE tasks SET status=1 WHERE id=$id");
    header("Location: home.php");
}

// Hapus
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($koneksi, "DELETE FROM tasks WHERE id=$id");
    header("Location: home.php");
}

// Ambil Tugas Per User
function get_user_tasks($koneksi, $order) {
    $uid = $_SESSION['user_id'];
    return mysqli_query($koneksi, "SELECT * FROM tasks WHERE user_id='$uid' ORDER BY $order");
}

// Ambil data tugas untuk diedit
function get_task_by_id($koneksi, $id) {
    $uid = $_SESSION['user_id'];
    $q = mysqli_query($koneksi, "SELECT * FROM tasks WHERE id=$id AND user_id='$uid'");
    return mysqli_fetch_assoc($q);
}
