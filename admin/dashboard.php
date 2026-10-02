<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

// =============================
// GET PROJECTS
// =============================

$sql = "SELECT * FROM projects ORDER BY created_at DESC";

$result = $conn->query($sql);

$totalProjects = $result ? $result->num_rows : 0;

// =============================
// GET MESSAGES
// =============================

$sql_messages = "SELECT COUNT(*) AS total FROM messages";

$result_messages = $conn->query($sql_messages);

if ($result_messages) {
    $message_data = $result_messages->fetch_assoc();
    $message_count = $message_data["total"];
} else {
    $message_count = 0;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Loyce</title>

    <style>
        /* =============================
            RESET
        ============================= */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* =============================
            BODY
        ============================= */

        body {
            font-family: Arial, sans-serif;
            background: #0a0a0a;
            color: #ffffff;
        }

        /* =============================
            DASHBOARD
        ============================= */

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* =============================
            SIDEBAR
        ============================= */

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

        /* LOGOUT */

        .logout {
            margin-top: 40px;
        }

        /* =============================
            MAIN CONTENT
        ============================= */

        .main-content {
            flex: 1;
            padding: 40px;
        }

        /* =============================
            TOPBAR
        ============================= */

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

        /* =============================
            BUTTONS
        ============================= */

        .btn-group {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .add-button {
            background: #d4af37;
            color: #000;
            padding: 13px 20px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            transition: 0.3s ease;
        }

        .add-button:hover {
            opacity: 0.85;
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

        /* =============================
            STATISTICS
        ============================= */

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #111;
            border: 1px solid #292929;
            padding: 25px;
        }

        .stat-card span {
            color: #888;
            font-size: 14px;
        }

        .stat-card h2 {
            color: #d4af37;
            font-size: 32px;
            margin-top: 10px;
        }

        /* =============================
            CARD LINKS
        ============================= */

        .card-link {
            text-decoration: none;
            display: block;
            transition: 0.3s ease;
        }

        .card-link:hover {
            border-color: #d4af37;
            transform: translateY(-3px);
        }

        /* =============================
            PROJECTS BOX
        ============================= */

        .projects-box {
            background: #111;
            border: 1px solid #292929;
            padding: 25px;
        }

        .projects-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .projects-header h2 {
            font-size: 22px;
        }

        /* =============================
            TABLE
        ============================= */

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
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
        }

        .project-number {
            color: #d4af37;
        }

        .type {
            color: #aaa;
        }

        .actions a {
            text-decoration: none;
            margin-right: 12px;
            font-size: 13px;
            font-weight: bold;
        }

        .edit-btn {
            color: #d4af37;
        }

        .edit-btn:hover {
            text-decoration: underline;
        }

        .delete-btn {
            color: #ff5c5c;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 30px;
        }

        /* =============================
            MOBILE
        ============================= */

        @media (max-width: 900px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
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

            .logo {
                margin-bottom: 20px;
            }

            .sidebar ul {
                display: flex;
                gap: 5px;
                overflow-x: auto;
            }

            .sidebar li {
                margin: 0;
            }

            .logout {
                margin-top: 10px;
            }

            .main-content {
                padding: 25px 15px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .btn-group {
                width: 100%;
                flex-direction: column;
            }

            .btn-group a {
                width: 100%;
                text-align: center;
            }

            .stats {
                grid-template-columns: 1fr;
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
                <a href="dashboard.php" class="active">Dashboard</a>
            </li>
            <li>
                <a href="add_project.php">Projects</a>
            </li>
            <li>
                <a href="messages.php">Messages</a>
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
                <h1>Welcome back, Loyce </h1>
                <p>Portfolio Management System</p>
            </div>
            <div class="btn-group">
                <a href="../index.php" class="secondary-button">View Portfolio</a>
            </div>
        </div>

        <!-- STATISTICS -->
        <div class="stats">
            <!-- TOTAL PROJECTS -->
            <div class="stat-card">
                <span>Total Projects</span>
                <h2><?php echo $totalProjects; ?></h2>
            </div>

            <!-- MESSAGES -->
            <a href="messages.php" class="stat-card card-link">
                <span>Messages</span>
                <h2><?php echo $message_count; ?></h2>
            </a>

            <!-- ADMIN -->
            <div class="stat-card">
                <span>Admin</span>
                <h2><?php echo htmlspecialchars($_SESSION["admin_username"]); ?></h2>
            </div>
        </div>

        <!-- PROJECTS -->
        <div class="projects-box">
            <div class="projects-header">
                <h2>Your Projects</h2>
                <a href="add_project.php" class="add-button">+ Add Project</a>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Technologies</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $number = 1; ?>
                        <?php while ($project = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="project-number">
                                    <?php echo str_pad($number, 2, "0", STR_PAD_LEFT); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($project["title"]); ?>
                                </td>
                                <td class="type">
                                    <?php echo htmlspecialchars($project["project_type"]); ?>
                                </td>
                                <td>
                                    <?php echo htmlspecialchars($project["technologies"]); ?>
                                </td>
                                <td class="actions">
                                    <a href="edit_project.php?id=<?php echo $project["id"]; ?>" class="edit-btn">Edit</a>
                                    <a href="delete_project.php?id=<?php echo $project["id"]; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                                </td>
                            </tr>
                            <?php $number++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="empty">No projects found.</td>
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