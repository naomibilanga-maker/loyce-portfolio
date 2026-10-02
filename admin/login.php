<?php

session_start();

require_once "../includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT id, username, password
            FROM admins
            WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin["password"])) {

            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_username"] = $admin["username"];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Incorrect password.";
        }

    } else {
        $error = "Admin account not found.";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Login | Loyce</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0a0a0a;
            color: white;

            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: #111;
            padding: 40px;
            border: 1px solid #333;
        }

        .logo {
            color: #d4af37;
            font-size: 14px;
            letter-spacing: 3px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .description {
            color: #999;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 14px;
            background: #1a1a1a;
            border: 1px solid #333;
            color: white;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #d4af37;
        }

        button {
            width: 100%;
            padding: 14px;
            background: #d4af37;
            color: #000;
            border: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        button:hover {
            opacity: 0.9;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #999;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            color: #d4af37;
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="logo">
            LOYCE
        </div>

        <h1>Admin Login</h1>

        <p class="description">
            Sign in to manage your portfolio.
        </p>

        <form action="login.php" method="POST">

            <div class="form-group">
                <label for="username">Username</label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    placeholder="Enter username"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter password"
                    required
                >
            </div>

            <button type="submit">
                Login
            </button>

        </form>

        <a href="../index.php" class="back-link">
            ← Back to Portfolio
        </a>

    </div>

</body>
</html>