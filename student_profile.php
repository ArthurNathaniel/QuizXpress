<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: student_login.php");
    exit();
}

// Fetch student data
$student_id = $_SESSION['student_id'];
$stmt = $conn->prepare("SELECT student_id, full_name, gender, class, email FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($student_id, $full_name, $gender, $class, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['full_name']; ?>!</h2>
    <h3>Your Profile</h3>
    <p><strong>Student ID:</strong> <?php echo $student_id; ?></p>
    <p><strong>Full Name:</strong> <?php echo $full_name; ?></p>
    <p><strong>Gender:</strong> <?php echo $gender; ?></p>
    <p><strong>Class:</strong> <?php echo $class; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>

    <p><a href="student_logout.php">Logout</a></p>
</body>
</html>
