<?php
session_start();
include 'db.php';

// Dummy login check, you should implement proper session management
// Ensure this page can only be accessed if the admin is logged in
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// For now, you can set a dummy session for testing purposes:
$_SESSION['admin_logged_in'] = true;
$admin_username = "Admin"; // Replace with actual username from session

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - QuizXpress</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }
        .container {
            margin: 20px;
        }
        .welcome {
            margin-bottom: 20px;
        }
        .card {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Welcome to QuizXpress Admin Dashboard</h1>
    </div>
    
    <div class="container">
        <div class="welcome">
            <h2>Hello, <?php echo $admin_username; ?>!</h2>
            <p>What would you like to do today?</p>
        </div>

        <div class="card">
            <h3><a href="register_teacher.php">Register a New Teacher</a></h3>
            <p>Add new teachers to the platform and manage existing ones.</p>
        </div>

        <div class="card">
            <h3><a href="view_teachers.php">View Teachers</a></h3>
            <p>View and manage all registered teachers.</p>
        </div>

        <div class="card">
            <h3><a href="view_students.php">View Students</a></h3>
            <p>View and manage students onboarded by teachers.</p>
        </div>

        <div class="card">
            <h3><a href="create_quiz.php">Create Quiz</a></h3>
            <p>Set up quizzes for teachers to assign to their students.</p>
        </div>

        <div class="card">
            <h3><a href="view_quizzes.php">View Quizzes</a></h3>
            <p>View and manage all quizzes created on the platform.</p>
        </div>

        <div class="card">
            <h3><a href="logout.php">Logout</a></h3>
            <p>Sign out of your admin account.</p>
        </div>
    </div>
</body>
</html>
