<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Đặt Hàng</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        width: 100%;
        max-width: 600px;
        background-color: #fff;
        padding: 20px;
        padding-top: 120px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .order-form {
        max-width: 100%;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group textarea {
        width: calc(100% - 10px);
        padding: 8px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .form-group textarea {
        resize: vertical;
    }

    .form-actions {
        margin-top: 20px;
        text-align: right;
    }

    .form-actions input[type="button"],
    .form-actions a {
        padding: 10px 20px;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        text-decoration: none;
        color: #fff;
    }

    .form-actions input[type="button"] {
        background-color: red;
        color: #fff;
    }

    .form-actions input[type="button"]:hover {
        background-color: brown;
    }

    .form-actions a {
        background-color: #6c757d;
        margin-left: 10px;
    }

    .form-actions a:hover {
        background-color: #5a6268;
    }

    #title {
        color: red;
    }
    </style>
</head>

<body>
    <?php
    $idget = $_GET['id'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quan_ly_vat_lieu";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Kết nối database thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM materials WHERE id = '" . $idget . "'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $idv = $row["id"];
            $name = $row["name"];
            $quantity = $row["quantity"];
            $price = $row["price"];
            $unit = $row["unit"];
        }
    } else {
        echo "Không tìm thấy vật liệu.";
        exit;
    }
    ?>
    <div class="container">
        <form method="POST" class="order-form" id="orderForm">
            <h2 id="title"><i class='bx bx-basket'></i> Nhập Thông Tin Để Hoàn Tất Đặt Hàng <i class='bx bx-basket'></i>
            </h2>

            <div class="form-group">
                <label for="tenvl">Tên vật liệu:</label>
                <input type="text" id="tenvl" name="tenvl" value="<?php echo htmlspecialchars($name); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="soluong">Số lượng:</label>
                <input type="text" id="soluong" name="soluong" value="<?php echo htmlspecialchars($quantity); ?>">
            </div>

            <div class="form-group">
                <label for="donvi">Đơn vị:</label>
                <input type="text" id="donvi" name="donvi" value="<?php echo htmlspecialchars($unit); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="gia"><i class='bx bx-money-withdraw'></i> Giá:</label>
                <input type="text" id="gia" name="gia" value="<?php echo htmlspecialchars($price); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="tenkh">Họ tên:</label>
                <input type="text" id="tenkh" name="tenkh" required>
            </div>

            <div class="form-group">
                <label for="sdt">Số điện thoại:</label>
                <input type="tel" id="sdt" name="sdt" required>
            </div>

            <div class="form-group">
                <label for="diachi">Địa chỉ:</label>
                <input type="text" id="diachi" name="diachi" required>
            </div>

            <div class="form-group">
                <label for="ghichu">Ghi chú:</label>
                <textarea id="ghichu" name="ghichu" rows="4"></textarea>
            </div>

            <div class="form-actions">
                <a href="cuahang.php">Quay lại</a>
                <input type="button" id="btnXemThongTin" value="Xem Thông Tin">
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = "";
        $idvl = $idv;
        $tenvl = $_POST['tenvl'];
        $soluong = $_POST['soluong'];
        $donvi = $_POST['donvi'];
        $gia = $_POST['gia'];
        $tongtien = $soluong * $gia; // Tính tổng tiền
        $tenkh = $_POST['tenkh'];
        $sdt = $_POST['sdt'];
        $diachi = $_POST['diachi'];
        $ghichu = $_POST['ghichu'];

        // Cập nhật số lượng vật liệu trong kho
        $sqlUpdateQuantity = "UPDATE materials SET quantity = quantity - $soluong WHERE id = $idv";

        if ($conn->query($sqlUpdateQuantity) !== TRUE) {
            $message = "Lỗi cập nhật số lượng vật liệu: " . $conn->error;
            $type = "error";
            echo "<script type='text/javascript'>
                Swal.fire({
                    title: '$message',
                    icon: '$type',
                    confirmButtonText: 'OK'
                });
            </script>";
            exit;
        }

        // Thêm đơn hàng mới vào cơ sở dữ liệu
        $don = 0;
        $sqlInsertOrder = "INSERT INTO donhang VALUES ('$id','$idvl','$tenvl', '$soluong', '$donvi', '$gia', $tongtien, '$tenkh', '$sdt', '$diachi', '$ghichu', '$don')";

        if ($conn->query($sqlInsertOrder) === TRUE) {
            $message = "Đặt hàng thành công";
            $type = "success";
        } else {
            $message = "Lỗi đặt hàng: " . $conn->error;
            $type = "error";
        }

        // Đóng kết nối cơ sở dữ liệu
        $conn->close();

        echo "<script type='text/javascript'>
            Swal.fire({
                title: '$message',
                icon: '$type',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'cuahang.php'; // Chuyển hướng về trang chủ hoặc trang khác sau khi người dùng nhấn OK
                }
            });
        </script>";
    }
    ?>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('orderForm');
        const btnXemThongTin = document.getElementById('btnXemThongTin');
        const soluongInput = document.getElementById('soluong');
        const giaInput = document.getElementById('gia');
        const tenkhInput = document.getElementById('tenkh');
        const sdtInput = document.getElementById('sdt');
        const diachiInput = document.getElementById('diachi');
        const ghichuInput = document.getElementById('ghichu');

        btnXemThongTin.addEventListener('click', function() {
            const soluongValue = parseInt(soluongInput.value);
            const giaValue = parseFloat(giaInput.value);
            const tongtien = soluongValue * giaValue;
            const tenkhValue = tenkhInput.value;
            const sdtValue = sdtInput.value;
            const diachiValue = diachiInput.value;
            const ghichuValue = ghichuInput.value;

            if (soluongValue <= 0 || soluongValue > <?php echo $quantity; ?>) {
                alert('Số lượng không hợp lệ. Vui lòng kiểm tra lại.');
            } else {
                Swal.fire({
                    title: 'Thông tin đặt hàng',
                    html: `
                        <p>Tên vật liệu: <?php echo htmlspecialchars($name); ?></p>
                        <p>Số lượng: ${soluongValue}</p>
                        <p>Giá: ${giaValue}</p>
                        <p>Tổng tiền: ${tongtien}</p>
                        <p>Họ tên: ${tenkhValue}</p>
                        <p>Số điện thoại: ${sdtValue}</p>
                        <p>Địa chỉ: ${diachiValue}</p>
                        <p>Ghi chú: ${ghichuValue}</p>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form khi người dùng nhấn "Thanh toán"
                    }
                });
            }
        });
    });
    </script>
</body>

</html>