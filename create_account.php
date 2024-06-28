<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Kiểm tra dữ liệu đầu vào
    if (empty($username) || empty($password) || !isset($role)) {
        die("Vui lòng điền đầy đủ thông tin!");
    }

    // Chuẩn bị câu lệnh SQL
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Gắn kết các tham số
        $stmt->bind_param("ssi", $username, $password, $role);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            echo "Người dùng mới đã được thêm thành công!";
        } else {
            echo "Lỗi khi thêm người dùng: " . $stmt->error;
        }

        // Đóng câu lệnh chuẩn bị
        $stmt->close();
    } else {
        echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
