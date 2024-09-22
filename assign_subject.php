<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject = $_POST['subject'];

    // Insert or update subject as needed
    $stmt = $conn->prepare("INSERT INTO subjects (subject_name) VALUES (?)");
    $stmt->bind_param("s", $subject);

    if ($stmt->execute()) {
        echo "<script>alert('Subject assigned successfully!');</script>";
    } else {
        echo "<script>alert('Error occurred. Please try again.');</script>";
    }
    $stmt->close();
}

// Fetch all subjects for display
$subjects_result = $conn->query("SELECT * FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Subject - QuizXpress</title>
</head>
<body>
    <h2>Assign Subject</h2>
    <form action="assign_subject.php" method="POST">
        <label for="subject">Subject Name:</label><br>
        <input type="text" id="subject" name="subject" required><br><br>
        <button type="submit">Assign Subject</button>
    </form>

    <h3>Existing Subjects</h3>
    <ul>
        <?php while ($row = $subjects_result->fetch_assoc()): ?>
            <li><?php echo $row['subject_name']; ?></li>
        <?php endwhile; ?>
    </ul>
    <p><a href="admin_dashboard.php">Back to Dashboard</a></p>
</body>
</html>
