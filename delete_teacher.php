<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Prepare the SQL delete statement
    $stmt = $conn->prepare("DELETE FROM teachers WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect back to the view teachers  page with a success message
        header("Location: view_teachers.php ?message=Teacher deleted successfully");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: view_teachers.php?error=Error deleting teacher");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
