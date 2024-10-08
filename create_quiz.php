<?php
include 'db.php';

// Fetch classes and subjects from the database
$classes_result = $conn->query("SELECT * FROM classes ORDER BY class_name ASC");
$subjects_result = $conn->query("SELECT * FROM subjects ORDER BY subject_name ASC");
$teachers_result = $conn->query("SELECT * FROM teachers ORDER BY full_name ASC");

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_title = $_POST['quiz_title'];
    $questions = $_POST['questions']; // Array of questions
    $options = $_POST['options']; // Array of options
    $correct_answers = $_POST['correct_answers']; // Array of correct answers
    $assigned_class = $_POST['assigned_class'];
    $assigned_subject = $_POST['assigned_subject'];
    $teacher_id = $_POST['teacher_id']; // The teacher responsible for the quiz
    $deadline = $_POST['deadline'];
    $duration = $_POST['duration']; // Duration for the quiz

    // Encode the questions, options, and correct answers into JSON format
    $encoded_questions = json_encode($questions);
    $encoded_options = json_encode($options);
    $encoded_correct_answers = json_encode($correct_answers);

    // Insert quiz into database
    $stmt = $conn->prepare("INSERT INTO quizzes (quiz_title, questions, options, correct_answers, assigned_class, assigned_subject, deadline, duration, teacher_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Now pass variables to bind_param
    $stmt->bind_param("ssssssssi", $quiz_title, $encoded_questions, $encoded_options, $encoded_correct_answers, $assigned_class, $assigned_subject, $deadline, $duration, $teacher_id);

    if ($stmt->execute()) {
        echo "<script>alert('Quiz created successfully!');</script>";
    } else {
        echo "<script>alert('Error creating quiz: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz - QuizXpress</title>
    <?php include 'cdn.php'?>
    <link rel="stylesheet" href="./css/teacher.css">
    <link rel="stylesheet" href="./css/quiz.css">
</head>

<body>
<?php include 'teachers_navbar.php'?>
    <div class="quiz_all">
        <h2>Create Quiz</h2>
        <form id="quizForm" action="" method="POST">
            <div class="forms">
                <label for="quiz_title">Quiz Title</label>
                <input type="text" id="quiz_title" name="quiz_title" required>
            </div>

            <div class="questions" id="questionsContainer">
                <h3>Questions</h3>
                <div class="question-block" id="questionBlock1">
                    <div class="forms">
                        <label for="question">Question 1</label>
                        <input type="text" name="questions[]" required>
                    </div>

                    <div class="forms options">
                        <label for="options">Options</label>
                        <input type="text" name="options[0][]" placeholder="A. Option 1" required>
                        <input type="text" name="options[0][]" placeholder="B. Option 2" required>
                        <input type="text" name="options[0][]" placeholder="C. Option 3" required>
                        <input type="text" name="options[0][]" placeholder="D. Option 4" required>
                    </div>

                    <div class="forms">
                        <label for="correct_answer">Correct Answer</label>
                        <select name="correct_answers[]" required>
                            <option value="" selected hidden>Select Answer</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>

                    <div class="actions_btns">
                        <button type="button" class="add_questions" onclick="addQuestion()">Add Another Question</button>
                        <button type="button" class="remove-button" onclick="removeQuestion(1)"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <div class="forms">
                <label for="assigned_subject">Assign Subject</label>
                <select id="assigned_subject" name="assigned_subject" required>
                    <option value="" selected hidden>Select Subject</option>
                    <?php while ($subject_row = $subjects_result->fetch_assoc()): ?>
                        <option value="<?php echo $subject_row['subject_name']; ?>"><?php echo $subject_row['subject_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="forms">
                <label for="assigned_class">Assign to Class</label>
                <select id="assigned_class" name="assigned_class" required>
                    <option value="" selected hidden>Select Class</option>
                    <?php while ($class_row = $classes_result->fetch_assoc()): ?>
                        <option value="<?php echo $class_row['class_name']; ?>"><?php echo $class_row['class_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="forms">
                <label for="teacher_id">Assign Teacher</label>
                <select id="teacher_id" name="teacher_id" required>
                    <option value="" selected hidden>Select Teacher</option>
                    <?php while ($teacher_row = $teachers_result->fetch_assoc()): ?>
                        <option value="<?php echo $teacher_row['id']; ?>"><?php echo $teacher_row['full_name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="forms">
                <label for="deadline">Deadline</label>
                <input type="datetime-local" id="deadline" name="deadline" required>
            </div>

            <div class="forms">
                <label for="duration">Quiz Duration (in minutes)</label>
                <input type="number" id="duration" name="duration" min="1" required>
            </div>

            <div class="forms">
                <button type="submit">Create Quiz</button>
            </div>
        </form>
    </div>

    <script>
        let questionCount = 1;

        function addQuestion() {
            questionCount++;
            const questionsContainer = document.getElementById('questionsContainer');
            const questionBlock = document.createElement('div');
            questionBlock.classList.add('question-block');
            questionBlock.id = `questionBlock${questionCount}`;
            questionBlock.innerHTML = `
                <div class="forms">
                    <label for="question">Question ${questionCount}</label>
                    <input type="text" name="questions[]" required>
                </div>
                <div class="forms options">
                    <label for="options">Options</label>
                    <input type="text" name="options[${questionCount - 1}][]" placeholder="A. Option 1" required>
                    <input type="text" name="options[${questionCount - 1}][]" placeholder="B. Option 2" required>
                    <input type="text" name="options[${questionCount - 1}][]" placeholder="C. Option 3" required>
                    <input type="text" name="options[${questionCount - 1}][]" placeholder="D. Option 4" required>
                </div>
                <div class="forms">
                    <label for="correct_answer">Correct Answer</label>
                    <select name="correct_answers[]" required>
                        <option value="" selected hidden>Select Answer</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <div class="actions_btns">
                    <button type="button" class="remove-button" onclick="removeQuestion(${questionCount})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
            questionsContainer.appendChild(questionBlock);
        }

        function removeQuestion(id) {
            const questionBlock = document.getElementById(`questionBlock${id}`);
            if (questionBlock) {
                questionBlock.remove();
                updateQuestionNumbers();
            }
        }

        function updateQuestionNumbers() {
            const questionBlocks = document.querySelectorAll('.question-block');
            questionBlocks.forEach((block, index) => {
                block.querySelector('label').innerText = `Question ${index + 1}`;
            });
        }
    </script>
</body>

</html>
