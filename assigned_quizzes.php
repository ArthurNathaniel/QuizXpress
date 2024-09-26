<?php
include 'db.php'; // Database connection

if (isset($_GET['quiz_id']) && isset($_GET['student_id'])) {
    $quiz_id = $_GET['quiz_id'];
    $student_id = $_GET['student_id'];

    // Prepare the query to fetch the student's response and score
    $stmt = $conn->prepare("SELECT * FROM student_quiz_responses WHERE quiz_id = ? AND student_id = ?");
    $stmt->bind_param("ii", $quiz_id, $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $response_data = $result->fetch_assoc();

    // Fetch quiz title
    $quiz_stmt = $conn->prepare("SELECT quiz_title FROM quizzes WHERE quiz_id = ?");
    $quiz_stmt->bind_param("i", $quiz_id);
    $quiz_stmt->execute();
    $quiz_result = $quiz_stmt->get_result();
    $quiz_data = $quiz_result->fetch_assoc();

    if (!$response_data) {
        echo "No quiz response found!";
        exit;
    }
} else {
    echo "Quiz ID or Student ID not provided!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Score</title>
    <link rel="stylesheet" href="./css/student.css"> <!-- Assume some styles here -->
</head>
<body>
    <h2><?php echo htmlspecialchars($quiz_data['quiz_title']); ?></h2>
    <p>Your score: <?php echo isset($response_data['score']) ? htmlspecialchars($response_data['score']) : 'No score available'; ?></p>
</body>
</html>
