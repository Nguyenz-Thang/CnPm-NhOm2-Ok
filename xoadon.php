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
    $laysl = "SELECT soluong FROM donhang WHERE id=$id";
    $re = $conn->query($laysl);
    if ($re->num_rows > 0) {
        while ($row = $re->fetch_assoc()) {
            $soluong = $row["soluong"];
        }
    }
    $idhd = "SELECT idvl FROM donhang WHERE id=$id";
    $result = $conn->query($idhd);
    if( $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $idv = $row['idvl'];
        }
    }
    if ($conn->query($sql) === TRUE) {
        echo "Đơn hàng đã được xóa thành công";
    } else {
        echo "Lỗi: " . $conn->error;
    }
    
    $csl = "UPDATE materials SET quantity = quantity+$soluong WHERE id=$idv";
    $conn->query($csl);
}

$conn->close();
header("Location: donhang.php");
?>