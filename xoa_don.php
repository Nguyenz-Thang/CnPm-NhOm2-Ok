<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_ly_vat_lieu";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $sql = "DELETE FROM donhang WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Đơn hàng đã được xóa thành công";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
header("Location: donhang.php");
?>