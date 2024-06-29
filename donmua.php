<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn mua</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: cadetblue;
        color: white;
        padding: 10px 0;
        text-align: center;
        position: relative;
    }

    header h1 {
        margin: 0;
        font-size: 2em;
    }

    header a img {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        height: 40px;
    }

    table {
        width: 90%;
        margin: 20px auto;
        border-collapse: collapse;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: cadetblue;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    button {
        padding: 8px 16px;
        margin: 4px;
        border: none;
        cursor: pointer;
    }

    button[type='submit'] {
        background-color: #4CAF50;
        color: white;
    }

    button[type='submit']:hover {
        background-color: #45a049;
    }

    button.disabled {
        background-color: #ddd;
        color: #999;
        cursor: default;
    }

    button.disabled:hover {
        background-color: #ddd;
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
        margin-top: 30%;
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
    </style>
    <script>
    function confirmAction(form, message) {
        if (confirm(message)) {
            form.submit();
        }
    }

    function filterOrders(status) {
        var url = 'filter_orders.php?status=' + status; // Thay đổi thành đường dẫn và file xử lý phù hợp
        window.location.href = url;
    }
    </script>
</head>

<body>
    <header>
        <h1><b>Đơn mua</b></h1>
        <a href="cuahang.php"><img src="./img/qdd.png" alt="Logo"></a>
    </header>
    <?php
    // Kết nối cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "quan_ly_vat_lieu";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM donhang";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Tên vật liệu</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th>Thành tiền</th>
                    <th>Tổng tiền hàng</th>
                    <th>Họ tên</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $don = $row["duyetdon"] == 1 ? "Đã xác nhận" : "Chưa được xác nhận";

            echo "<tr>
                    <td>" . $row["tenvl"] . "</td>
                    <td>" . $row["soluong"] . "</td>
                    <td>" . $row["donvi"] . "</td>
                    <td>" . number_format($row["gia"], 0, ',', '.') . " VNĐ</td>
                    <td>" . number_format($row["tongtien"], 0, ',', '.') . " VNĐ</td>
                    <td>" . $row["tenkh"] . "</td>
                    <td>" . $row["sdt"] . "</td>
                    <td>" . $row["diachi"] . "</td>
                    <td>" . $row["ghichu"] . "</td>
                    <td>" . $don . "</td>";

            if ($row['duyetdon'] == 0) {
                echo "<td>
                        <form method='post' action='xoadon.php' style='display:inline;' onsubmit='event.preventDefault(); confirmAction(this, \"Bạn có chắc chắn muốn xóa hóa đơn này?\");'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <button type='submit'>Hủy đơn hàng</button>
                        </form>
                    </td>
                  </tr>";
            } else {
                echo "<td>
                        <button class='disabled' disabled>Hủy đơn hàng</button>
                    </td>
                  </tr>";
            }
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center; color: #333;'>Không có đơn hàng nào</p>";
    }

    $conn->close();
    ?>
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