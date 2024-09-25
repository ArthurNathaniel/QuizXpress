<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Student deleted successfully!'); window.location='view_students.php';</script>";
    } else {
        echo "<script>alert('Error occurred. Please try again.'); window.location='view_students.php';</script>";
    }

    $stmt->close();
}
?>
