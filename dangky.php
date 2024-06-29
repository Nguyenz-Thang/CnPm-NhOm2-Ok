<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hệ Thống Quản Lý Vật Liệu</title>
    <link rel="stylesheet" type="text/css" href="/css/index.css" />
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #8bbec5;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url("https://sudospaces.com/hoaphat-com-vn/2023/01/101471718-729356127873912-8830961117876450954-n.png");
        background-size: 90%;
    }

    header {
        position: absolute;
        top: 0;
        width: 100%;
        background-color: #ffffff;
        color: #f57c00;
        text-align: center;
        padding: 1.5rem 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }

    .login-container {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .login-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .login-container h2 {
        margin-bottom: 2rem;
        font-size: 1.8rem;
        color: #f57c00;
        text-align: center;
    }

    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .login-container label {
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #f57c00;
    }

    .login-container input {
        padding: 0.8rem;
        margin-bottom: 1.5rem;
        border: 1px solid #b2dfdb;
        border-radius: 6px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .login-container input:focus {
        border-color: #004d40;
        outline: none;
    }

    .login-container button {
        padding: 0.8rem;
        background-color: #f57c00;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .login-container button:hover {
        background-color: #f57c00;
    }
    </style>
</head>

<body>
    <main>
        <div class="login-container">
            <h2>Đăng Ký</h2>
            <form action="create_account.php" method="POST">
                <label for="username">Tên Đăng Nhập:</label>
                <input type="text" id="username" name="username" required />

                <label for="password">Mật Khẩu:</label>
                <input type="password" id="password" name="password" required />

                <button type="submit">Đăng ký</button>
                <p>Đã có tài khoản?</p><a href="index.php">Đăng nhập</a>
            </form>
        </div>
    </main>
</body>

</html>