<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bảng Điều Khiển - Hệ Thống Quản Lý Vật Liệu</title>
    <link rel="stylesheet" href="styles.css" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        background-image: url("./img/mg.jpg");
    }

    header {
        width: 100%;
        background-color: #ffffff;
        color: #f57c00;
        text-align: center;
        padding: 1.5rem 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        opacity: 0.9;
    }

    header nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        justify-content: center;
        gap: 1.5rem;
    }

    header nav ul li {
        display: inline;
    }

    header nav ul li a {
        color: #f57c00;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    header nav ul li a:hover {
        color: #f57c00;
    }

    .button-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        /* Căn trái các button */
        gap: 20px;
        /* Khoảng cách giữa các button */
        margin-top: 40px;
    }

    .custom-button {
        background-color: #ffffff;
        border: none;
        color: #f57c00;
        padding: 20px 40px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 24px;
        cursor: pointer;
        transition: background-color 0.3s, transform 0.3s;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .custom-button:hover {
        background-color: #ffffff;
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .custom-button h1 {
        margin: 0;
        font-size: 28px;
    }

    main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
    }

    .dashboard-section {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin: 20px;
    }

    .dashboard-section h2 {
        margin-bottom: 1rem;
        font-size: 1.5rem;
        color: #f57c00;
    }

    .card-container {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .card {
        background-color: #ffffff;
        padding: 1.5rem;
        margin: 1rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 220px;
        text-decoration: none;
        color: #f57c00;
        transition: background-color 0.3s, transform 0.3s;
    }

    .card:hover {
        background-color: #f5f5f5;
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card h3 {
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
        color: #f57c00;
    }

    #tk {
        background-color: transparent;
        border: none;
        color: #f57c00;
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.3s;
    }

    #tk:hover {
        color: #f57c00;
    }

    /* Styling for logout link (#dx) */
    #dx {
        color: #f57c00;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 4px;
        background-color: #ffffff;
        transition: background-color 0.3s, color 0.3s;
        margin-left: 10px;
    }

    #dx:hover {
        background-color: #ffffff;
        color: #f57c00;
    }
    </style>
</head>

<body>
    <header>
        <h1>Hệ Thống Quản Lý Vật Liệu</h1>
        <?php 
            if (!isset($_GET["username"]) || $_GET["username"] === null) {
                // Xử lý khi username không tồn tại hoặc là null
            } else {
                $idd = $_GET["username"];
            }
           
            ?>
        <button id="tk" type="button"><i class='bx bxs-user'></i></button>
        <a id="dx" href="index.php">Đăng xuất</a>
    </header>
    <div class="button-container">
        <a href="quanli.php">
            <button class="custom-button">
                <h1><i class='bx bxs-briefcase-alt-2'></i> Quản lí vật liệu</h1>
            </button>
        </a>

        <a href="nhapxuatvl.php">
            <button class="custom-button">
                <h1><i class='bx bx-import'></i> Nhập và xuất kho <i class='bx bx-export'></i></h1>
            </button>
        </a>
        <?php
        if (!isset($_GET["username"]) || $_GET["username"] === null) {
            // Xử lý khi username không tồn tại hoặc là null
            $idd = "";
        } else {
            $idd = $_GET["username"];
        }
         
        ?>
        <a href="cuahang.php?username=<?php echo $idd; ?>">
            <button class="custom-button">
                <h1><i id="ok" class='bx bx-basket'></i> Cửa hàng </i></h1>
            </button>
        </a>
        <a href="donhang.php">
            <button class="custom-button">
                <h1><i id="ok" class='bx bx-basket'></i> Đơn hàng </i></h1>
            </button>
        </a>
    </div>
</body>

</html>