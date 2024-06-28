<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : null; // Kiểm tra nếu role không được cung cấp

    // Kiểm tra dữ liệu đầu vào
    if (empty($username) || empty($password)) {
        die("Vui lòng điền đầy đủ thông tin!");
    }

    // Chuẩn bị câu lệnh SQL
    if ($role !== null) {
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Gắn kết các tham số
            $stmt->bind_param("sss", $username, $password, $role);
        } else {
            echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
            $conn->close();
            exit;
        }
    } else {
        // Nếu role không được cung cấp, chỉ bind username và password
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Gắn kết các tham số
            $stmt->bind_param("ss", $username, $password);
        } else {
            echo "Lỗi chuẩn bị câu lệnh: " . $conn->error;
            $conn->close();
            exit;
        }
    }

    // Thực thi câu lệnh
    if ($stmt->execute()) {
        echo "Người dùng mới đã được thêm thành công!";
    } else {
        echo "Lỗi khi thêm người dùng: " . $stmt->error;
    }

    // Đóng câu lệnh chuẩn bị
    $stmt->close();
} else {
    echo "Yêu cầu không hợp lệ.";
}

// Đóng kết nối cơ sở dữ liệu
$conn->close();
?>
