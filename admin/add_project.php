<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $project_type = trim($_POST["project_type"]);
    $technologies = trim($_POST["technologies"]);
    $project_link = trim($_POST["project_link"]);
    $github_link = trim($_POST["github_link"]);

    if (
        empty($title) ||
        empty($description) ||
        empty($project_type) ||
        empty($technologies)
    ) {

        $error = "Please fill in all required fields.";

    } else {

        $sql = "INSERT INTO projects
                (
                    title,
                    description,
                    technologies,
                    project_link,
                    github_link,
                    project_type
                )
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);

        // Show the real database error if prepare() fails
        if (!$stmt) {
            die("Database error: " . $conn->error);
        }

        $stmt->bind_param(
            "ssssss",
            $title,
            $description,
            $technologies,
            $project_link,
            $github_link,
            $project_type
        );

        if ($stmt->execute()) {

            $success = "Project added successfully!";

        } else {

            $error = "Database error: " . $stmt->error;

        }

        $stmt->close();
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

    <title>Add Project | Loyce</title>

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
            max-width: 800px;
            margin: auto;
        }

        .top {
            margin-bottom: 35px;
        }

        .back {
            color: #d4af37;
            text-decoration: none;
            font-size: 14px;
        }

        h1 {
            margin-top: 20px;
            font-size: 32px;
        }

        .subtitle {
            color: #888;
            margin-top: 8px;
        }

        .form-box {
            background: #111;
            border: 1px solid #292929;
            padding: 35px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 14px;
            background: #181818;
            color: white;
            border: 1px solid #333;
            font-size: 15px;
        }

        textarea {
            min-height: 150px;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #d4af37;
        }

        .required {
            color: #d4af37;
        }

        .button {
            background: #d4af37;
            color: #000;
            border: none;
            padding: 14px 25px;
            font-weight: bold;
            cursor: pointer;
            font-size: 15px;
        }

        .button:hover {
            opacity: 0.9;
        }

        .error {
            background: #351818;
            color: #ff8b8b;
            padding: 12px;
            margin-bottom: 20px;
        }

        .success {
            background: #18351f;
            color: #8cff9b;
            padding: 12px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <a href="dashboard.php" class="back">
            ← Back to Dashboard
        </a>

        <h1>
            Add New Project
        </h1>

        <p class="subtitle">
            Add a project to your portfolio.
        </p>

    </div>


    <div class="form-box">

        <?php if (!empty($error)): ?>

            <div class="error">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <?php if (!empty($success)): ?>

            <div class="success">
                <?php echo htmlspecialchars($success); ?>
            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="add_project.php"
        >

            <div class="form-group">

                <label for="title">

                    Project Title

                    <span class="required">*</span>

                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    placeholder="Example: Car Marketplace"
                    required
                >

            </div>


            <div class="form-group">

                <label for="description">

                    Description

                    <span class="required">*</span>

                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Describe your project..."
                    required
                ></textarea>

            </div>


            <div class="form-group">

                <label for="project_type">

                    Project Type

                    <span class="required">*</span>

                </label>

                <select
                    id="project_type"
                    name="project_type"
                    required
                >

                    <option value="">
                        Select project type
                    </option>

                    <option value="Personal Project">
                        Personal Project
                    </option>

                    <option value="Academic Project">
                        Academic Project
                    </option>

                    <option value="Learning Project">
                        Learning Project
                    </option>

                </select>

            </div>


            <div class="form-group">

                <label for="technologies">

                    Technologies

                    <span class="required">*</span>

                </label>

                <input
                    type="text"
                    id="technologies"
                    name="technologies"
                    placeholder="HTML, CSS, JavaScript, PHP"
                    required
                >

            </div>


            <div class="form-group">

                <label for="project_link">
                    Project Link
                </label>

                <input
                    type="url"
                    id="project_link"
                    name="project_link"
                    placeholder="https://example.com"
                >

            </div>


            <div class="form-group">

                <label for="github_link">
                    GitHub Link
                </label>

                <input
                    type="url"
                    id="github_link"
                    name="github_link"
                    placeholder="https://github.com/username/project"
                >

            </div>


            <button
                type="submit"
                class="button"
            >
                Add Project
            </button>

        </form>

    </div>

</div>

</body>

</html>