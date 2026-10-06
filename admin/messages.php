<?php
session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

// =============================
// FETCH ALL MESSAGES
// =============================
$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);
$totalMessages = $result ? $result->num_rows : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages | Dashboard</title>

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
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #111111;
            border-right: 1px solid #2a2a2a;
            padding: 30px 20px;
        }

        .logo {
            color: #d4af37;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 3px;
            margin-bottom: 50px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        .sidebar a {
            display: block;
            padding: 13px 15px;
            color: #999;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #1d1d1d;
            color: #d4af37;
        }

        .logout {
            margin-top: 40px;
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        .topbar h1 {
            font-size: 30px;
        }

        .topbar p {
            color: #888;
            margin-top: 8px;
        }

        .secondary-button {
            background: transparent;
            color: #d4af37;
            border: 1px solid #d4af37;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            transition: 0.3s ease;
        }

        .secondary-button:hover {
            background: rgba(212, 175, 55, 0.1);
        }

        /* MESSAGES BOX */
        .messages-box {
            background: #111;
            border: 1px solid #292929;
            padding: 25px;
        }

        .messages-header {
            margin-bottom: 25px;
        }

        .messages-header h2 {
            font-size: 22px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 16px 12px;
            text-align: left;
            border-bottom: 1px solid #292929;
        }

        th {
            color: #888;
            font-size: 13px;
            text-transform: uppercase;
        }

        td {
            color: #ddd;
            font-size: 14px;
        }

        .msg-number {
            color: #d4af37;
            font-weight: bold;
        }

        .msg-email {
            color: #aaa;
        }

        .msg-body {
            max-width: 300px;
            word-break: break-word;
        }

        .date {
            color: #777;
            font-size: 12px;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 30px;
        }

        @media (max-width: 800px) {
            .dashboard {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #292929;
            }
            .sidebar ul {
                display: flex;
                gap: 5px;
                overflow-x: auto;
            }
            .main-content {
                padding: 25px 15px;
            }
        }
    </style>
</head>

<body>

<div class="dashboard">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            LOYCE
        </div>
        <ul>
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="add_project.php">Projects</a>
            </li>
            <li>
                <a href="messages.php" class="active">Messages</a>
            </li>
            <li>
                <a href="settings.php">Settings</a>
            </li>
        </ul>
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOPBAR -->
        <div class="topbar">
            <div>
                <h1>Client Messages</h1>
                <p>Review inquiries sent from your portfolio website</p>
            </div>
            <div>
                <a href="dashboard.php" class="secondary-button">Back to Dashboard</a>
            </div>
        </div>

        <!-- MESSAGES TABLE -->
        <div class="messages-box">
            <div class="messages-header">
                <h2>All Messages (<?= $totalMessages ?>)</h2>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Date Received</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $number = 1; ?>
                        <?php while ($msg = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="msg-number">
                                    <?= str_pad($number, 2, "0", STR_PAD_LEFT); ?>
                                </td>
                                <td>
                                    <?= htmlspecialchars($msg["name"]); ?>
                                </td>
                                <td class="msg-email">
                                    <a href="mailto:<?= htmlspecialchars($msg["email"]); ?>" style="color: #d4af37; text-decoration: none;">
                                        <?= htmlspecialchars($msg["email"]); ?>
                                    </a>
                                </td>
                                <td>
                                    <?= htmlspecialchars($msg["subject"]); ?>
                                </td>
                                <td class="msg-body">
                                    <?= nl2br(htmlspecialchars($msg["message"])); ?>
                                </td>
                                <td class="date">
                                    <?= htmlspecialchars($msg["created_at"]); ?>
                                </td>
                            </tr>
                            <?php $number++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty">No messages found yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</div>

</body>
</html>