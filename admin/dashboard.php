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

    <!-- Optional: Inter font for a more premium feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif;
            background: #0b0b0f;
            color: #e5e7eb;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        ul {
            list-style: none;
        }

        /* =============================
           DASHBOARD LAYOUT
        ============================= */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* =============================
           SIDEBAR
        ============================= */
        .sidebar {
            width: 260px;
            background: #0f1115;
            border-right: 1px solid #1f2228;
            padding: 28px 18px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        .logo {
            color: #d4af37;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 2.5px;
            margin-bottom: 40px;
            padding-left: 10px;
        }

        .sidebar ul {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .sidebar li {
            margin: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            color: #9ca3af;
            border-radius: 8px;
            transition: all 0.25s ease;
            font-weight: 600;
            font-size: 14px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #15181f;
            color: #d4af37;
        }

        .sidebar a.active {
            border-left: 3px solid #d4af37;
            padding-left: 11px;
        }

        .logout {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #1f2228;
        }

        /* =============================
           MAIN CONTENT
        ============================= */
        .main-content {
            flex: 1;
            padding: 40px 40px 60px;
            background: linear-gradient(180deg, #0b0b0f 0%, #0a0a0e 100%);
        }

        /* =============================
           TOPBAR
        ============================= */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 36px;
            gap: 20px;
        }

        .topbar h1 {
            font-size: 28px;
            font-weight: 800;
            color: #f3f4f6;
            letter-spacing: -0.3px;
        }

        .topbar p {
            color: #9ca3af;
            margin-top: 6px;
            font-size: 14px;
        }

        /* =============================
           BUTTONS
        ============================= */
        .btn-group {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .add-button,
        .secondary-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            transition: all 0.25s ease;
            white-space: nowrap;
        }

        .add-button {
            background: #d4af37;
            color: #0b0b0f;
            border: 2px solid #d4af37;
        }

        .add-button:hover {
            background: #f5e6a3;
            border-color: #f5e6a3;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(212, 175, 55, 0.35);
        }

        .secondary-button {
            background: transparent;
            color: #d4af37;
            border: 2px solid #d4af37;
        }

        .secondary-button:hover {
            background: rgba(212, 175, 55, 0.12);
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(212, 175, 55, 0.25);
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
            background: #0f1115;
            border: 1px solid #1f2228;
            padding: 24px;
            border-radius: 12px;
            transition: all 0.25s ease;
        }

        .stat-card:hover {
            border-color: #2b2f38;
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(2, 6, 23, 0.35);
        }

        .stat-card span {
            color: #9ca3af;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-card h2 {
            color: #d4af37;
            font-size: 32px;
            margin-top: 8px;
            font-weight: 800;
        }

        .card-link {
            display: block;
        }

        .card-link:hover .stat-card {
            border-color: #d4af37;
        }

        /* =============================
           PROJECTS BOX
        ============================= */
        .projects-box {
            background: #0f1115;
            border: 1px solid #1f2228;
            padding: 26px;
            border-radius: 12px;
        }

        .projects-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 22px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .projects-header h2 {
            font-size: 20px;
            font-weight: 800;
            color: #f3f4f6;
            letter-spacing: -0.2px;
        }

        /* =============================
           TABLE
        ============================= */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            border: 1px solid #1f2228;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th,
        td {
            padding: 14px 14px;
            text-align: left;
            border-bottom: 1px solid #1f2228;
        }

        th {
            color: #9ca3af;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.6px;
            background: #0b0d12;
        }

        td {
            color: #e5e7eb;
            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #0b0d12;
        }

        .project-number {
            color: #d4af37;
            font-weight: 700;
            font-family: ui-monospace, SFMonoRegular, "Fira Code", monospace;
            font-size: 13px;
        }

        .type {
            color: #d1d5db;
        }

        .actions a {
            text-decoration: none;
            margin-right: 14px;
            font-size: 13px;
            font-weight: 700;
            transition: color 0.2s ease;
        }

        .edit-btn {
            color: #d4af37;
        }

        .edit-btn:hover {
            color: #f5e6a3;
        }

        .delete-btn {
            color: #f87171;
        }

        .delete-btn:hover {
            color: #fca5a5;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 36px 20px;
            font-size: 14px;
        }

        /* =============================
           MOBILE
        ============================= */
        @media (max-width: 1100px) {
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #1f2228;
                height: auto;
                position: relative;
                padding: 18px 16px;
            }

            .logo {
                margin-bottom: 14px;
                padding-left: 0;
            }

            .sidebar ul {
                flex-direction: row;
                gap: 6px;
                overflow-x: auto;
            }

            .sidebar a {
                padding: 10px 12px;
                font-size: 13px;
            }

            .sidebar a.active {
                border-left: none;
                border-bottom: 3px solid #d4af37;
                padding-bottom: 7px;
            }

            .logout {
                margin-top: 10px;
                padding-top: 10px;
                border-top: none;
            }

            .main-content {
                padding: 24px 16px 40px;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
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

            .projects-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .projects-header .add-button {
                width: 100%;
                text-align: center;
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
                <h1>Welcome back, <?php echo htmlspecialchars($_SESSION["admin_username"] ?? "Loyce"); ?></h1>
                <p>Portfolio Management System</p>
            </div>
            <div class="btn-group">
                <a href="add_project.php" class="add-button">+ Add Project</a>
                <a href="../index.php" class="secondary-button">View Portfolio</a>
            </div>
        </div>

        <!-- STATISTICS -->
        <div class="stats">
            <!-- TOTAL PROJECTS -->
            <div class="stat-card">
                <span>Total Projects</span>
                <h2><?php echo (int)$totalProjects; ?></h2>
            </div>

            <!-- MESSAGES -->
            <a href="messages.php" class="card-link">
                <div class="stat-card">
                    <span>Messages</span>
                    <h2><?php echo (int)$message_count; ?></h2>
                </div>
            </a>

            <!-- ADMIN -->
            <div class="stat-card">
                <span>Admin</span>
                <h2><?php echo htmlspecialchars($_SESSION["admin_username"] ?? "Admin"); ?></h2>
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