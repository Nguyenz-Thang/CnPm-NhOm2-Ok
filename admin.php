<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị Viên - Hệ Thống Quản Lý Vật Liệu</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="/css/admin.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f4f8;
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
    }

    header {
        width: 100%;
        background-color: #006064;
        color: #fff;
        text-align: center;
        padding: 1.5rem 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        transition: color 0.3s;
    }

    header nav ul li a:hover {
        color: #ffcc80;
    }

    main {
        margin: 20px;
        width: 100%;
        max-width: 1200px;
    }

    .admin-section {
        background-color: #fff;
        padding: 2rem;
        margin-bottom: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .admin-section h2 {
        margin-top: 0;
        font-size: 1.5rem;
        color: #006064;
    }

    .form-container {
        max-width: 400px;
        margin: 0 auto;
        text-align: left;
    }

    label {
        display: block;
        margin: 10px 0 5px;
    }

    input[type="text"],
    input[type="password"],
    input[type="email"] {
        width: 100%;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    button {
        background-color: #006064;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s, transform 0.3s;
    }

    button:hover {
        background-color: #006070;
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tbody tr:hover {
        background-color: #f1f1f1;
    }
    </style>
</head>

<body>
    <header>
        <h1>Hệ Thống Quản Lý Vật Liệu - Quản Trị Viên</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Bảng Điều Khiển</a></li>
                <li><a href="admin.php">Quản Lý Tài Khoản</a></li>
                <li><a href="logout.php">Đăng Xuất</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="admin-section">
            <h2>Tạo Tài Khoản</h2>
            <div class="form-container">
                <form action="create_account.php" method="POST">
                    <label for="username">Tên Đăng Nhập:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="password">Mật Khẩu:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="role">Vai trò:</label>
                    <input type="role" id="role" name="role" required>
                        <option value="0">Người dùng thường: 0</option>
                        <option value="1">Quản trị viên: 1</option>


                    <button type="submit">Tạo Tài Khoản</button>
                </form>
            </div>
        </section>
        <section class="admin-section">
            <h2>Danh Sách Tài Khoản</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tên Đăng Nhập</th>
                        <th>Mật Khẩu</th>

                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'config.php';
                    $sql = "SELECT username,  password FROM users";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['username']}</td>
                                    
                                    <td>{$row['password']}</td>
                                    <td><button onclick=\"deleteUser('{$row['username']}')\"><i class='bx bxs-user-x'></i></button></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Không có tài khoản nào</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
    <script>
    function deleteUser(username) {
        if (confirm("Bạn có chắc chắn muốn xóa tài khoản này?")) {
            window.location.href = "delete_user.php?username=" + username;
        }
    }
    </script>
</body>

</html>