<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $class = $_POST['class'];
    $subject = $_POST['subject'];
    $gender = $_POST['gender'];

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM teachers WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Insert new teacher into the database
        $stmt = $conn->prepare("INSERT INTO teachers (full_name, email, password, class, subject, gender) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $full_name, $email, $password, $class, $subject, $gender);

        if ($stmt->execute()) {
            echo "<script>alert('Teacher registered successfully!');</script>";
        } else {
            echo "<script>alert('Error occurred. Please try again.');</script>";
        }
        $stmt->close();
    }
    $check->close();
}

// Fetch classes and subjects from the database
$classes_result = $conn->query("SELECT id, class_name FROM classes");
$subjects_result = $conn->query("SELECT id, subject_name FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Teacher - QuizXpress</title>
</head>
<body>
    <h2>Register Teacher</h2>
    <form action="register_teacher.php" method="POST">
        <label for="full_name">Full Name:</label><br>
        <input type="text" id="full_name" name="full_name" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>

        <label for="class">Class:</label><br>
        <select id="class" name="class" required>
            <?php while ($row = $classes_result->fetch_assoc()): ?>
                <option value="<?php echo $row['class_name']; ?>"><?php echo $row['class_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="subject">Subject:</label><br>
        <select id="subject" name="subject" required>
            <?php while ($row = $subjects_result->fetch_assoc()): ?>
                <option value="<?php echo $row['subject_name']; ?>"><?php echo $row['subject_name']; ?></option>
            <?php endwhile; ?>
        </select><br>

        <label for="gender">Gender:</label><br>
        <select id="gender" name="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select><br><br>

        <button type="submit">Register Teacher</button>
    </form>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
