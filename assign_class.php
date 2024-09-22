<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class = $_POST['class'];

    // Insert or update class as needed
    $stmt = $conn->prepare("INSERT INTO classes (class_name) VALUES (?)");
    $stmt->bind_param("s", $class);

    if ($stmt->execute()) {
        echo "<script>alert('Class assigned successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred. Please try again.');</script>";
    }
    $stmt->close();
}

// Fetch all classes for display
$classes_result = $conn->query("SELECT * FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Class - QuizXpress</title>
</head>
<body>
    <h2>Assign Class</h2>
    <form action="assign_class.php" method="POST">
        <label for="class">Class Name:</label><br>
        <input type="text" id="class" name="class" required><br><br>
        <button type="submit">Assign Class</button>
    </form>

    <h3>Existing Classes</h3>
    <ul>
        <?php while ($row = $classes_result->fetch_assoc()): ?>
            <li><?php echo $row['class_name']; ?></li>
        <?php endwhile; ?>
    </ul>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
