<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_ly_vat_lieu"; // Tên cơ sở dữ liệu bạn đã tạo

$conn = new mysqli($servername, $username, $password, $dbname);

// Hàm xử lý upload ảnh
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
        // Tìm ID tiếp theo
        $sql_max_id = "SELECT MAX(id) as max_id FROM materials";
        $result_max_id = $conn->query($sql_max_id);
        $row_max_id = $result_max_id->fetch_assoc();
        $next_id = $row_max_id['max_id'] + 1;
    
        // Lấy thông tin từ form
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $unit = $_POST['unit'];
        $image = uploadImage($_FILES['image']);
    
        // Thêm bản ghi mới với ID tiếp theo
        $sql = "INSERT INTO materials (id, name, quantity, price, unit, image) VALUES ($next_id, '$name', $quantity, $price, '$unit', '$image')";
        $conn->query($sql);
        
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    header("Location: quanli.php");
?>
    <h3>Thêm Vật Liệu Thành Công</h3>
    <a href="quanli.php">
        <h3>Quay Lại Trang Quản Lí</h3>
    </a>

</body>

</html>