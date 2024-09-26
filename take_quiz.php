<?php
include 'db.php'; // Database connection

if (isset($_GET['quiz_id'])) {
    $quiz_id = $_GET['quiz_id'];

    // Fetch quiz details
    $quiz_result = $conn->query("SELECT * FROM quizzes WHERE quiz_id = $quiz_id");
    $quiz_data = $quiz_result->fetch_assoc();

    // Decode the JSON data for questions, options, and correct answers
    $questions = json_decode($quiz_data['questions'], true);
    $options = json_decode($quiz_data['options'], true);
    $correct_answers = json_decode($quiz_data['correct_answers'], true);
    $deadline = strtotime($quiz_data['deadline']);
    $duration = $quiz_data['duration'] * 60; // Convert minutes to seconds

    // Assume we have a logged-in student
    $student_id = 1; // Placeholder for actual student ID

    // Fetch the number of attempts made by the student for this quiz
    $attempts_result = $conn->query("SELECT COUNT(*) as attempts FROM quiz_attempts WHERE quiz_id = $quiz_id AND student_id = $student_id");
    $attempts_data = $attempts_result->fetch_assoc();
    $attempts_count = $attempts_data['attempts'];

    if ($attempts_count >= 2) {
        echo "<p>You have already used your two attempts for this quiz.</p>";
        exit;
    }
} else {
    echo "Quiz not found!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz</title>
    <link rel="stylesheet" href="./css/student.css"> <!-- Assume some styles here -->
    <style>
        #countdown {
            font-weight: bold;
            color: red;
        }
    </style>
</head>
<body>
    <h2><?php echo $quiz_data['quiz_title']; ?></h2>

    <div id="countdown"></div>

    <form id="quizForm" action="submit_quiz.php" method="POST">
        <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">

        <?php foreach ($questions as $index => $question): ?>
            <div class="question-block">
                <p><strong>Question <?php echo $index + 1; ?>:</strong> <?php echo $question; ?></p>

                <?php foreach ($options[$index] as $option_key => $option_value): ?>
                    <div class="option">
                        <label>
                            <input type="radio" name="answers[<?php echo $index; ?>]" value="<?php echo $option_key; ?>" required>
                            <?php echo $option_value; ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <button type="submit">Submit Quiz</button>
    </form>

    <script>
        // Countdown Timer
        const deadline = new Date(<?php echo json_encode(date('Y-m-d H:i:s', $deadline)); ?>).getTime();
        const duration = <?php echo $duration; ?> * 1000; // Convert seconds to milliseconds

        const timer = setInterval(function() {
            const now = new Date().getTime();
            const distance = deadline - now;

            // Calculate remaining time
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the countdown element
            document.getElementById("countdown").innerHTML = "Time remaining: " + minutes + "m " + seconds + "s ";

            // If the countdown is finished, alert and disable the form
            if (distance < 0) {
                clearInterval(timer);
                document.getElementById("countdown").innerHTML = "EXPIRED";
                alert("Time's up! Your quiz will be submitted automatically.");
                document.getElementById("quizForm").submit();
            }
        }, 1000);
    </script>
</body>
</html>
