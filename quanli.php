<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quan_ly_vat_lieu"; // Tên cơ sở dữ liệu bạn đã tạo

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hàm lấy danh sách vật liệu
function getMaterials() {
    global $conn;
    $sql = "SELECT * FROM materials";
    $result = $conn->query($sql);
    $materials = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    return $materials;
}
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


// Hàm sửa thông tin vật liệu

// Hàm xóa vật liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM materials WHERE id=$id";
    $conn->query($sql);

    // Kiểm tra và sắp xếp lại ID
    $sql = "SELECT id FROM materials ORDER BY id";
    $result = $conn->query($sql);
    $counter = 1;
    while ($row = $result->fetch_assoc()) {
        $current_id = $row['id'];
        if ($current_id != $counter) {
            $update_sql = "UPDATE materials SET id=$counter WHERE id=$current_id";
            $conn->query($update_sql);
        }
        $counter++;
    }

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

$materials = getMaterials();
function searchMaterials($searchKeyword) {
    global $conn;
    $sql = "SELECT * FROM materials WHERE name LIKE '%$searchKeyword%'";
    $result = $conn->query($sql);
    $materials = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    return $materials;
}

// Xử lý tìm kiếm khi có yêu cầu POST từ form tìm kiếm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $searchKeyword = $_POST['searchKeyword'];
    $materials = searchMaterials($searchKeyword);
} else {
    $materials = getMaterials();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Quản Lý Vật Liệu</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #ffffff;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: darkcyan;
        color: #ffffff;
        padding: 1rem;
        text-align: center;
        position: relative;
    }

    header img {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
    }

    header h1 {
        margin: 0;
        font-size: 1.8rem;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 2rem auto;
        background-color: azure;
        padding: 2rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 1px;
    }

    .material-list {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .material-card {
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: calc(16.66% - 1rem);
        /* 6 items per row */
        padding: 0.5rem 1rem;
        /* Reduced vertical padding */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .material-card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .material-card img {
        max-width: 60%;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .material-card h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #f57c00;
    }

    .material-card p {
        margin: 0.2rem 0;
    }

    .material-card p#het {
        color: red;
    }

    .actions {
        display: flex;
        justify-content: center;
        /* Center the buttons */
        gap: 0.5rem;
        /* Add some space between buttons */
        margin-top: 0.5rem;
    }

    .but1,
    .but2 {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        color: #f57c00;
    }

    .but1:hover {
        background-color: #ffffff;
        color: #f57c00;
    }

    .but2:hover {
        color: #f57c00;
    }

    form {
        margin-top: 1rem;
    }

    form div {
        margin-bottom: 1rem;
    }

    form label {
        display: block;
        margin-bottom: 0.5rem;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="file"] {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .tkim {
        background-color: #ddd;
        color: #f57c00;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
    }

    .tkim:hover {
        background-color: darkseagreen;
        color: #f57c00;
        text-decoration: none;
    }

    form button:hover {
        background-color: #ffffff;
    }

    h2 {
        color: #f57c00;
        margin-bottom: 1rem;
    }

    #them {
        background-color: #f57c00;
        color: #ffffff;
    }
    </style>
</head>

<body>
    <header>
        <a href="dashboard.php"><img src="./img/qdd.png" alt="Logo"></a>
        <h1><b>Quản Lý Vật Liệu</b></h1>

    </header>

    <div class="container">
        <h2><b>Danh Sách Vật Liệu</b></h2>
        <button id="them" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal"><b>Thêm vật
                liệu mới</b></button>
        <form method="POST">
            <input type="text" name="searchKeyword" placeholder="Nhập tên vật liệu...">
            <button class="tkim" type="submit" name="search"><b>Tìm Kiếm</b></button>
            <button class="tkim" type="submit" class="huytim"><a href="quanli.php"><b>Hủy Tìm Kiếm</b></a></button>
        </form>
        <div class="material-list">
            <?php foreach ($materials as $material) : ?>
            <div class="material-card">
                <?php if (!empty($material['image'])) : ?>
                <img width="200px" src="<?php echo $material['image']; ?>" alt="<?php echo $material['name']; ?>">
                <?php else : ?>
                <img src="default-image.jpg" alt="No Image">
                <?php endif; ?>
                <h3 id="name"><?php echo $material['name']; ?></h3>
                <p id="kho">Kho: <?php 
                if($material['quantity']<=0){
                    echo '<p id="het">Hết</p>';
                }else{
                echo $material['quantity']; 
                }?></p>
                <i>
                    <p>Đơn Vị: <?php echo $material['unit']; ?></p>
                </i>
                <b>
                    <p id="gia">Giá: <?php echo ' '. number_format($material["price"], 0, ',', '.') . ' VNĐ';  ?></p>
                </b>
                <div class="action-buttons">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $material['id']; ?>">
                        <button class="but1" type="submit" name="delete"><i
                                onclick="return confirm('Bạn có chắc chắn muốn xóa không');"
                                class='bx bx-trash'></i></button>
                    </form>
                    <button class="but2" type="button" data-toggle="modal" data-target="#sua" onclick="editMaterial('<?php echo $material['id']; ?>', '<?php echo $material['name']; ?>',
                             '<?php echo $material['quantity']; ?>', '<?php echo $material['price']; ?>', 
                             '<?php echo $material['unit']; ?>', '<?php echo $material['image']; ?>')"><i
                            class='bx bx-edit'></i></button>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Form thêm vật liệu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="them.php" method="POST" enctype="multipart/form-data">
                            <h2>Thêm Vật Liệu Mới</h2>
                            <div>
                                <label for="name">Tên Vật Liệu:</label>
                                <input type="text" id="name" name="name" required>
                            </div>
                            <div>
                                <label for="quantity">Số Lượng:</label>
                                <input type="number" id="quantity" name="quantity" required>
                            </div>
                            <div>
                                <label for="unit">Đơn Vị:</label>
                                <input type="text" id="unit" name="unit" required>
                            </div>
                            <div>
                                <label for="price">Giá:</label>
                                <input type="number" id="price" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="image">Ảnh:</label>
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>

                            <button type="submit" name="add">Thêm</button>

                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="sua">
            <div class="modal-dialog">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Form thêm vật liệu</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="suavl.php" method="POST" enctype="multipart/form-data">
                            <h2>Sửa Vật Liệu</h2>
                            <input type="hidden" id="edit_id" name="id">
                            <div>
                                <label for="edit_name">Tên Vật Liệu:</label>
                                <input type="text" id="edit_name" name="name" required>
                            </div>
                            <div>
                                <label for="edit_quantity">Số Lượng:</label>
                                <input type="number" id="edit_quantity" name="quantity" required>
                            </div>
                            <div>
                                <label for="edit_unit">Đơn Vị:</label>
                                <input type="text" id="edit_unit" name="unit" required>
                            </div>
                            <div>
                                <label for="edit_price">Giá:</label>
                                <input type="number" id="edit_price" name="price" step="0.01" required>
                            </div>
                            <div>
                                <label for="edit_image">Ảnh:</label>
                                <input type="file" id="edit_image" name="image" accept="image/*">
                            </div>

                            <button type="submit" name="update">Cập Nhật</button>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>


    </div>

    <script>
    function editMaterial(id, name, quantity, price, unit, image) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_quantity').value = quantity;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_unit').value = unit;
    }
    </script>
</body>

</html>