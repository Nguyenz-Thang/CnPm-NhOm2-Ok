<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Truy vấn để lấy thông tin người dùng
    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username_db, $password_db, $role);
    $stmt->fetch();

    // Kiểm tra mật khẩu
    if ($password === $password_db) {  // So sánh mật khẩu trực tiếp
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username_db;
        $_SESSION['role'] = $role;

        // Kiểm tra vai trò
        if ($role == 1) {
            // Điều hướng đến trang quản trị viên
            header("Location: dashboard.php");
        } else {
            // Điều hướng đến trang người dùng
            header("Location: cuahang.php");
        }
        exit();
    } else {
        echo "Tên người dùng hoặc mật khẩu không đúng!";
    }
    $stmt->close();
}
$conn->close();
?>
