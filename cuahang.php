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
        while ($row = $result->fetch_assoc()) {
            $materials[] = $row;
        }
    }
    return $materials;
}

$materials = getMaterials();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Đơn Hàng - Quản Lý Vật Liệu</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-image: url("./img/banner.jpg");
        overflow-x: hidden;
        /* Thêm dòng này để ngăn cuộn ngang */
    }

    header {
        background-color: cadetblue;
        width: 100%;
        color: #fff;
        padding: 1.5rem 0;
        text-align: center;
        position: relative;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
        color: coral;
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
        margin-left: 70px;
        font-size: 1.8rem;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 2rem auto;
        background-color: aliceblue;
        padding: 2rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        overflow: hidden;
        /* Đảm bảo không có phần tử nào tràn ra ngoài container */
    }

    .material-list {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }

    .material-card:nth-child(even) {
        background-color: #eef2f7;
    }

    .material-card {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 1px;
        width: calc(19% - 2rem);
        /* Sửa lại width để tránh tràn */
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;

    }

    .material-card:hover {
        transform: scale(1.01);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .material-card img {
        max-width: 100%;
        border-radius: 5px;
        margin-bottom: 1rem;
        width: 90px;
        margin: 0 auto;
    }

    .material-card h3 {
        margin: 0;
        font-size: 1.2rem;
        margin-bottom: 0.5rem;
        padding-top: 5px;
    }

    .material-card p {
        margin: 0.2rem 0;
    }

    #name {
        color: #006064;
        cursor: pointer;
    }

    #name:hover {
        color: brown;
    }

    #gia {
        color: blueviolet;
    }

    #kho {
        color: chocolate;
    }

    .lh {
        border: 1px solid black;
        border-left: #006064;
        border-right: #006064;
        border-bottom: #006064;
        width: 100%;
        background-color: #fff;
        text-align: center;
        padding: 2%;
        margin-top: 7%;
    }

    #ok {
        font-size: 90%;
        padding-bottom: 10px;
    }

    .lhok {
        transform: scale(2);
    }

    .lhok i {
        padding: 5px;
        cursor: pointer;
        color: black;
    }

    #het {
        color: red;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .mua,
    .gio {
        display: inline-block;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s, color 0.3s;
    }

    .mua {
        background-color: cadetblue;
        color: #fff;

        color: antiquewhite;
    }

    .mua:hover {
        background-color: mediumseagreen;
        border-color: #004d40;
        text-decoration: none;
    }

    .gio {
        background-color: #fff;
        color: brown;
        border: 1px solid #004d40;
    }

    .gio:hover {
        background-color: #ddd;
    }

    #blue {
        color: blue;
    }

    #it {
        color: crimson;
    }

    .menu {
        color: #006064;
        width: 100%;
        padding: 1.1rem 0;
        text-align: center;
        background-color: beige;
        color: coral;
    }

    #dx:hover {
        text-decoration: none;
    }

    #gioithieu {
        background-color: cadetblue;
        /* Màu nền */
        color: #fff;
        /* Màu chữ */
        border: none;
        /* Không có viền */
        padding: 10px 20px;
        /* Khoảng cách bên trong */
        border-radius: 4px;
        /* Đường viền cong */
        cursor: pointer;
        /* Con trỏ chuột */
        transition: background-color 0.3s, color 0.3s;
        /* Hiệu ứng chuyển đổi màu */
    }

    #gioithieu:hover {
        background-color: darkblue;
        /* Màu nền khi di chuột qua */
    }

    #tk {
        background-color: beige;
        /* Màu nền */
        color: brown;
        /* Màu chữ */
        border: none;
        /* Không có viền */
        padding: 10px 20px;
        /* Khoảng cách bên trong */
        border-radius: 4px;
        /* Đường viền cong */
        cursor: pointer;
        /* Con trỏ chuột */
        transition: background-color 0.3s, color 0.3s;
        /* Hiệu ứng chuyển đổi màu */
    }

    .mua.disabled {
        pointer-events: none;
        /* Ngăn chặn sự kiện click */
        color: #ccc;
        /* Màu chữ xám */
        text-decoration: none;
        /* Không gạch chân */
        cursor: default;
        /* Con trỏ mặc định */
    }

    .tkim {
        /* Button styles, assuming this is your search button */
        background-color: #006064;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        text-decoration: none;
    }

    .tkim:hover {
        background-color: #004d40;
    }

    input[type="text"] {
        padding: 10px;
        /* Padding around text inside input */
        margin-right: 10px;
        /* Space between input and buttons */
        border: 1px solid #ddd;
        /* Border color */
        border-radius: 4px;
        /* Rounded corners */
        font-size: 16px;
        /* Font size */
        width: 300px;
        /* Adjust width as needed */
        transition: border-color 0.3s ease;
        /* Transition effect for border color */
    }

    input[type="text"]:focus {
        border-color: dodgerblue;
        /* Border color when input is focused */
        outline: none;
        /* Remove default focus outline */
    }

    #donmua {
        background-color: cadetblue;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        text-decoration: none;
        display: inline-block;
        margin-top: 10px;
        /* Thêm margin để cách các phần tử khác */
    }

    #donmua:hover {
        background-color: mediumseagreen;
    }
    </style>
</head>

<body>
    <header>
        <h1><i class='bx bxs-basket'></i> Cửa Hàng <i class='bx bxs-basket'></i></h1>
    </header>
    <div class="menu">
        <button type="button" id="gioithieu" data-toggle="modal" data-target="#gt">Giới thiệu</button>
        <div class="taikhoan">
            <?php 
            if (!isset($_GET["username"]) || $_GET["username"] === null) {
                // Xử lý khi username không tồn tại hoặc là null
            } else {
                $idd = $_GET["username"];
            }
           
            ?>
            <button id="tk" type="button"><i class='bx bxs-user'></i></button>
            <a id="dx" href="index.php">Đăng xuất</a>
        </div>
    </div>
    <div class="modal" id="gt">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Giới Thiệu</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <img width="90%" src="./img/loggoo.webp" alt="">
                    <p>
                        Hòa Phát là Tập đoàn sản xuất công nghiệp hàng đầu Việt Nam. Khởi đầu từ một Công ty chuyên buôn
                        bán các loại máy xây dựng từ tháng 8/1992, Hòa Phát lần lượt mở rộng sang các lĩnh vực khác như
                        Nội thất, ống thép, thép xây dựng, điện lạnh, bất động sản và nông nghiệp. Ngày 15/11/2007, Hòa
                        Phát chính thức niêm yết cổ phiếu trên thị trường chứng khoán Việt Nam với mã chứng khoán HPG.

                        Hiện nay, Tập đoàn hoạt động trong 05 lĩnh vực: Gang thép (thép xây dựng, thép cuộn cán nóng) -
                        Sản phẩm thép (gồm Ống thép, tôn mạ, thép rút dây, thép dự ứng lực) - Nông nghiệp - Bất động sản
                        – Điện máy gia dụng. Sản xuất thép là lĩnh vực cốt lõi chiếm tỷ trọng 90% doanh thu và lợi nhuận
                        toàn Tập đoàn. Với công suất 8.5 triệu tấn thép thô/năm, Hòa Phát là doanh nghiệp sản xuất thép
                        lớn nhất khu vực Đông Nam Á.

                        Tập đoàn Hòa Phát giữ thị phần số 1 Việt Nam về thép xây dựng, ống thép; Top 5 về tôn mạ. Hiện
                        nay, Hòa Phát nằm trong Top 5 doanh nghiệp tư nhân lớn nhất Việt Nam, Top 50 DN niêm yết hiệu
                        quả nhất, Top 30 DN nộp ngân sách Nhà nước lớn nhất Việt Nam, Top 3 DN có vốn điều lệ lớn nhất
                        thị trường chứng khoán, Top 10 cổ phiếu có vốn hóa lớn nhất thị trường chứng khoán Việt Nam.
                    </p>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <form method="POST">
            <input type="text" name="searchKeyword" placeholder="Nhập tên vật liệu...">
            <button class="tkim" type="submit" name="search">Tìm Kiếm</button>
            <button class="tkim" type="submit" class="huytim"><a href="cuahang.php">Hủy Tìm Kiếm</a></button>
        </form>
        <a id="donmua" href="donmua.php">Đơn mua</a>
        <h2>Các Vật Liệu</h2>
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
                <div class="actions">
                    <a class="gio" href="giohang.php?id=<?php echo $material['id']; ?>"><i
                            class='bx bx-cart-add'></i></a>
                    <a class="mua" href="nhapttmua.php?id=<?php echo $material['id']; ?>">Mua</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="lh">
        <h4><b>Hỗ trợ</b></h4>
        <p id="ok">Mọi thắc mắc và góp ý cần hỗ trợ xin vui lòng liên hệ:
        </p>
        <div class="lhok">
            <a target="_blank" href="https://www.facebook.com/ntt.thang.2004/"><i id="blue"
                    class='bx bxl-facebook-circle'></i></a>
            <a target="_blank" href="https://www.instagram.com/n.t_thanq_/"><i id="it" class='bx bxl-instagram'></i></a>
            <i id="blue" class='bx bxl-telegram'></i>
            <i class='bx bxl-discord-alt'></i>
        </div>
    </div>
</body>

</html>