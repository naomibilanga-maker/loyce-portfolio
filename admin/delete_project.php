<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once "../includes/config.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid project ID.");
}

$id = (int) $_GET["id"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete Project</title>
</head>

<body>

<script>

const confirmDelete = confirm(
    "Are you sure you want to delete this project?"
);

if (confirmDelete) {

    <?php

    $sql = "DELETE FROM projects WHERE id = ?";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database error: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "alert('Project deleted successfully.');";
    } else {
        echo "alert('Database error: " . addslashes($stmt->error) . "');";
    }

    $stmt->close();
    $conn->close();

    ?>

} else {

    alert("Delete cancelled.");

}

</script>

</body>

</html>