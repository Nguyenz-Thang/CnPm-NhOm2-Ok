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
    $sql = "UPDATE donhang SET duyetdon = 1 WHERE id = $id";
    $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "Đơn hàng đã được duyệt thành công";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
header("Location: donhang.php");
?>