<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Đơn Hàng</title>
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
    </style>
    <script>
    function confirmAction(form, message) {
        if (confirm(message)) {
            form.submit();
        }
    }
    </script>
</head>

<body>
    <header>
        <h1>Quản lí Đơn hàng</h1>
        <a href="dashboard.php"><img src="./img/qdd.png" alt="Logo"></a>
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
                    <th>ID</th>
                    <th>ID Vật liệu</th>
                    <th>Tên vật liệu</th>
                    <th>Số lượng</th>
                    <th>Đơn vị</th>
                    <th>Thành tiền</th>
                    <th>Tổng tiền hàng</th>
                    <th>Tên khách hàng</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Ghi chú</th>
                    <th>Trạng Thái</th>
                    <th>Thao Tác</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            $don = $row["duyetdon"] == 1 ? "Đã xét duyệt" : "Chưa xét duyệt";

            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["idvl"] . "</td>
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
                        <form method='post' action='duyetdon.php' style='display:inline;' onsubmit='event.preventDefault(); confirmAction(this, \"Bạn có chắc chắn muốn duyệt hóa đơn này?\");'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <button type='submit'>Duyệt hóa đơn</button>
                        </form>
                        <form method='post' action='xoadon.php' style='display:inline;' onsubmit='event.preventDefault(); confirmAction(this, \"Bạn có chắc chắn muốn xóa hóa đơn này?\");'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <button type='submit'>Xóa</button>
                        </form>
                    </td>
                  </tr>";
            } else {
                echo "<td>
                        <button class='disabled' disabled>Đã duyệt</button>
                        <form method='post' action='xoadon.php' style='display:inline;' onsubmit='event.preventDefault(); confirmAction(this, \"Bạn có chắc chắn muốn xóa hóa đơn này?\");'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <button type='submit'>Xóa</button>
                        </form>
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
</body>

</html>