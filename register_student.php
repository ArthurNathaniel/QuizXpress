<?php
session_start();
include 'db.php';

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

// Function to generate a 6-digit student ID
function generateStudentId() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $class = $_POST['class'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $student_id = generateStudentId();

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM students WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Insert new student into the database
        $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, gender, class, email, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $student_id, $full_name, $gender, $class, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Student registered successfully!');</script>";
        } else {
            echo "<script>alert('Error occurred. Please try again.');</script>";
        }
        $stmt->close();
    }
    $check->close();
}

// Fetch classes from the database
$classes_result = $conn->query("SELECT id, class_name FROM classes");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Student - QuizXpress</title>
    <?php include 'cdn.php'?>
    <link rel="stylesheet" href="./css/teacher.css">
    <link rel="stylesheet" href="./css/register_student.css">
</head>
<body>
<?php include 'teachers_navbar.php' ?>
    <div class="register_student_all">
    <div class="forms_title">
    <h2>Register Student</h2>
    </div>
    <form action="register_student.php" method="POST">
     <div class="forms">
     <label for="full_name">Full Name:</label>
     <input type="text" id="full_name" placeholder="Enter your full name" name="full_name" required>
     </div>

     <div class="forms">
     <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
        <option value="" selected hidden>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
     </div>

     <div class="forms">
     <label for="class">Class:</label>
        <select id="class" name="class" required>
        <option value="" selected hidden>Select Class</option>
            <?php while ($row = $classes_result->fetch_assoc()): ?>
                <option value="<?php echo $row['class_name']; ?>"><?php echo $row['class_name']; ?></option>
            <?php endwhile; ?>
        </select>
     </div>
<div class="forms">
    
<label for="email">Email:</label>
        <input type="email" placeholder="Enter your email address" id="email" name="email" required>
</div>

     <div class="forms">
     <label for="password">Password:</label>
     <input type="password" placeholder="Enter your password" id="password" name="password" required>
     </div>

       <div class="forms">
       <button type="submit">Register Student</button>
       </div>
    </form>
    <p><a href="teacher_dashboard.php">Back to Dashboard</a></p>
    </div>
</body>
</html>
