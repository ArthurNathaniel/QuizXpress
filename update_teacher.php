<?php
include 'db.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $gender = $_POST['gender'];

    // Prepare an SQL statement to update the teacher record
    $stmt = $conn->prepare("UPDATE teachers SET full_name=?, email=?, class=?, subject=?, gender=? WHERE id=?");
    $stmt->bind_param("sssssi", $full_name, $email, $class, $subject, $gender, $id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the view page with a success message
        header("Location: view_teachers.php?status=success");
        exit();
    } else {
        // Redirect back with an error message
        header("Location: view_teachers.php?status=error");
        exit();
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
