<?php
include 'db.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = $_POST['quiz_id'];
    $student_id = $_POST['student_id'];
    $student_answers = $_POST['answers']; // This is an array of student answers

    // Fetch the correct answers for the quiz
    $quiz_result = $conn->query("SELECT correct_answers FROM quizzes WHERE quiz_id = $quiz_id");
    $quiz_data = $quiz_result->fetch_assoc();
    $correct_answers = json_decode($quiz_data['correct_answers'], true);

    // Calculate score
    $score = 0;
    foreach ($correct_answers as $index => $correct_answer) {
        if (isset($student_answers[$index]) && $student_answers[$index] == $correct_answer) {
            $score++;
        }
    }

    // Encode student responses as JSON
    $encoded_responses = json_encode($student_answers);

    // Insert the student's quiz response into the database
    $stmt = $conn->prepare("INSERT INTO student_quiz_responses (student_id, quiz_id, responses, score, submitted_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iisi", $student_id, $quiz_id, $encoded_responses, $score);

    if ($stmt->execute()) {
        echo "<script>alert('Quiz submitted successfully! Your score: $score');</script>";
        header("Location: view_score.php?quiz_id=$quiz_id&student_id=$student_id");
        exit; // Ensure no further code is executed
    } else {
        echo "Error submitting quiz: " . $conn->error;
    }
}
?>
