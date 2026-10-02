<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

$sql = "SELECT * FROM messages ORDER BY created_at DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages | Loyce</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0a0a0a;
            color: white;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .top {
            margin-bottom: 30px;
        }

        .back {
            color: #d4af37;
            text-decoration: none;
        }

        h1 {
            margin-top: 20px;
        }

        .message {
            background: #111;
            border: 1px solid #292929;
            padding: 25px;
            margin-bottom: 20px;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 15px;
        }

        .name {
            font-size: 18px;
            font-weight: bold;
        }

        .date {
            color: #888;
            font-size: 13px;
        }

        .email {
            color: #d4af37;
            margin-bottom: 10px;
        }

        .subject {
            font-weight: bold;
            margin-bottom: 12px;
        }

        .message-text {
            color: #ccc;
            line-height: 1.6;
        }

        .no-messages {
            background: #111;
            border: 1px solid #292929;
            padding: 30px;
            color: #888;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <a href="dashboard.php" class="back">
            ← Back to Dashboard
        </a>

        <h1>Messages</h1>

    </div>


    <?php if ($result->num_rows > 0): ?>

        <?php while ($message = $result->fetch_assoc()): ?>

            <div class="message">

                <div class="message-header">

                    <div class="name">
                        <?php echo htmlspecialchars($message["name"]); ?>
                    </div>

                    <div class="date">
                        <?php echo htmlspecialchars($message["created_at"]); ?>
                    </div>

                </div>


                <div class="email">

                    <?php echo htmlspecialchars($message["email"]); ?>

                </div>


                <div class="subject">

                    Subject:
                    <?php echo htmlspecialchars($message["subject"]); ?>

                </div>


                <div class="message-text">

                    <?php echo nl2br(htmlspecialchars($message["message"])); ?>

                </div>

            </div>

        <?php endwhile; ?>

    <?php else: ?>

        <div class="no-messages">

            No messages yet.

        </div>

    <?php endif; ?>

</div>

</body>

</html>