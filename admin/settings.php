<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

$success = "";
$error = "";


// =============================
// CHANGE PASSWORD
// =============================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $currentPassword = $_POST["current_password"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";


    // Check empty fields

    if (
        empty($currentPassword) ||
        empty($newPassword) ||
        empty($confirmPassword)
    ) {

        $error = "Please fill in all fields.";

    }

    // Check new passwords

    elseif ($newPassword !== $confirmPassword) {

        $error = "New passwords do not match.";

    }

    // Check password length

    elseif (strlen($newPassword) < 8) {

        $error = "New password must be at least 8 characters.";

    }

    else {

        // Get current admin

        $adminId = $_SESSION["admin_id"];

        $sql = "SELECT password FROM admins WHERE id = ?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param("i", $adminId);

        $stmt->execute();

        $result = $stmt->get_result();

        $admin = $result->fetch_assoc();

        $stmt->close();


        if (!$admin) {

            $error = "Admin account not found.";

        }

        // Check current password

        elseif (
            !password_verify(
                $currentPassword,
                $admin["password"]
            )
        ) {

            $error = "Current password is incorrect.";

        }

        else {

            // Hash new password

            $hashedPassword = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );


            // Update password

            $sql = "UPDATE admins SET password = ? WHERE id = ?";

            $stmt = $conn->prepare($sql);

            $stmt->bind_param(
                "si",
                $hashedPassword,
                $adminId
            );


            if ($stmt->execute()) {

                $success = "Password changed successfully.";

            } else {

                $error = "Something went wrong. Please try again.";

            }


            $stmt->close();

        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Settings | Loyce</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family: Arial, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
            min-height: 100vh;
            padding: 40px;
        }


        .container {
            max-width: 700px;
            margin: auto;
        }


        .back {
            display: inline-block;
            color: #d4af37;
            text-decoration: none;
            margin-bottom: 30px;
        }


        .back:hover {
            text-decoration: underline;
        }


        h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }


        .description {
            color: #888;
            margin-bottom: 30px;
        }


        .settings-box {
            background: #111;
            border: 1px solid #292929;
            padding: 30px;
        }


        .settings-box h2 {
            font-size: 22px;
            margin-bottom: 25px;
        }


        .form-group {
            margin-bottom: 20px;
        }


        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #ccc;
        }


        .form-group input {
            width: 100%;
            padding: 13px;
            background: #0a0a0a;
            border: 1px solid #333;
            color: #ffffff;
            border-radius: 4px;
            outline: none;
        }


        .form-group input:focus {
            border-color: #d4af37;
        }


        .button {
            background: #d4af37;
            color: #000;
            border: none;
            padding: 13px 20px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }


        .button:hover {
            opacity: 0.85;
        }


        .success {
            background: #102b19;
            border: 1px solid #1f6b36;
            color: #7ee2a8;
            padding: 13px;
            margin-bottom: 20px;
        }


        .error {
            background: #2b1010;
            border: 1px solid #6b1f1f;
            color: #ff8c8c;
            padding: 13px;
            margin-bottom: 20px;
        }


        @media (max-width: 600px) {

            body {
                padding: 20px;
            }


            .settings-box {
                padding: 20px;
            }

        }

    </style>

</head>


<body>


<div class="container">


    <a
        href="dashboard.php"
        class="back"
    >
        ← Back to Dashboard
    </a>


    <h1>
        Settings
    </h1>


    <p class="description">
        Manage your administrator account.
    </p>


    <div class="settings-box">


        <h2>
            Change Password
        </h2>


        <?php if (!empty($success)): ?>

            <div class="success">

                <?php echo htmlspecialchars($success); ?>

            </div>

        <?php endif; ?>


        <?php if (!empty($error)): ?>

            <div class="error">

                <?php echo htmlspecialchars($error); ?>

            </div>

        <?php endif; ?>


        <form
            action="settings.php"
            method="POST"
        >


            <div class="form-group">

                <label for="current_password">
                    Current Password
                </label>

                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="new_password">
                    New Password
                </label>

                <input
                    type="password"
                    id="new_password"
                    name="new_password"
                    required
                >

            </div>


            <div class="form-group">

                <label for="confirm_password">
                    Confirm New Password
                </label>

                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    required
                >

            </div>


            <button
                type="submit"
                class="button"
            >
                Change Password
            </button>


        </form>


    </div>


</div>


</body>

</html>