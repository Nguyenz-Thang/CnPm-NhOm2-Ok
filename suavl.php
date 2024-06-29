<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_ly_vat_lieu"; // Tên cơ sở dữ liệu bạn đã tạo

$conn = new mysqli($servername, $username, $password, $dbname);
function uploadImage($file) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra file có phải là hình ảnh
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return null;
    }

    // Kiểm tra file đã tồn tại
    if (file_exists($target_file)) {
        return $target_file;
    }

    // Kiểm tra kích thước file
    if ($file["size"] > 500000) {
        return null;
    }

    // Cho phép các định dạng file nhất định
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return null;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return null;
    }
}

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $image = uploadImage($_FILES['image']);
    $sql = "UPDATE materials SET name='$name', quantity=$quantity, price=$price, unit='$unit'";
    if ($image) {
        $sql .= ", image='$image'";
    }
    $sql .= " WHERE id=$id";
    $conn->query($sql);
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
header("Location: quanli.php");
?>