<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare the SQL statement to select the teacher with the given email
    $stmt = $conn->prepare("SELECT id, full_name, password FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $full_name, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start the session and store the teacher's ID and name
            session_start();
            $_SESSION['teacher_id'] = $id;
            $_SESSION['teacher_name'] = $full_name;

            // Redirect to a protected page (e.g., teacher_dashboard.php)
            header("Location: teacher_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('No account found with that email. Please register.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Login - QuizXpress</title>
</head>
<body>
    <h2>Teacher Login</h2>
    <form action="teacher_login.php" method="POST">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <p><a href="register_teacher.php">Don't have an account? Register here.</a></p>
</body>
</html>
