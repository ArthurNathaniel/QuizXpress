<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE students SET full_name = ?, gender = ?, class = ?, email = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssssi", $full_name, $gender, $class, $email, $password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE students SET full_name = ?, gender = ?, class = ?, email = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $full_name, $gender, $class, $email, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Student updated successfully!'); window.location='view_students.php';</script>";
    } else {
        echo "<script>alert('Error occurred. Please try again.'); window.location='view_students.php';</script>";
    }

    $stmt->close();
}
?>
