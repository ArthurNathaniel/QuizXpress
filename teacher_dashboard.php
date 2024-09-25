<?php
session_start();

// Check if the teacher is logged in
if (!isset($_SESSION['teacher_id'])) {
    header("Location: teacher_login.php");
    exit();
}

// Get the teacher's name from the session
$teacher_name = $_SESSION['teacher_name'];

// Database connection
include 'db.php';

// Fetch total number of students
$total_students_result = $conn->query("SELECT COUNT(*) as total FROM students");
$total_students = $total_students_result->fetch_assoc()['total'];

// Fetch number of students in each class
$class_counts = $conn->query("
    SELECT c.class_name, COUNT(s.student_id) as count 
    FROM students s
    JOIN classes c ON s.class = c.class_name
    GROUP BY c.class_name
");
$class_data = [];
while ($row = $class_counts->fetch_assoc()) {
    $class_data[$row['class_name']] = $row['count'];
}

// Fetch gender distribution
$gender_counts = $conn->query("SELECT gender, COUNT(*) as count FROM students GROUP BY gender");
$gender_data = [];
while ($row = $gender_counts->fetch_assoc()) {
    $gender_data[$row['gender']] = $row['count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard - QuizXpress</title>
    <?php include 'cdn.php' ?>
    <!-- <link rel="stylesheet" href="./css/base.css"> -->
    <link rel="stylesheet" href="./css/teacher.css">
    <link rel="stylesheet" href="./css/dashboard.css">

</head>

<body>
    <?php include 'teachers_navbar.php' ?>
    <div class="teachers_dashboard">
        <h2>Welcome, Sir <?php echo htmlspecialchars($teacher_name); ?>!</h2>
        



        <div class="students">
        <h3>Total Number of Students: </h3>
        <h1><?php echo $total_students; ?></h1>
        </div>

        <div class="chart_grid">
            <div class="chart">
                <canvas id="classChart" width="400" height="200"></canvas>
            </div>
            <div class="chart">
                <canvas id="genderChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Chart for total students in each class
        const classData = {
            labels: <?php echo json_encode(array_keys($class_data)); ?>,
            datasets: [{
                label: 'Students per Class',
                data: <?php echo json_encode(array_values($class_data)); ?>,
                backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)',
                                'rgb(255, 159, 64)'
                            ],
                borderWidth: 1
            }]
        };

        const classConfig = {
            type: 'bar',
            data: classData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        const classChart = new Chart(
            document.getElementById('classChart'),
            classConfig
        );

        // Chart for gender distribution
        const genderData = {
            labels: <?php echo json_encode(array_keys($gender_data)); ?>,
            datasets: [{
                label: 'Gender Distribution',
                data: <?php echo json_encode(array_values($gender_data)); ?>,
                backgroundColor: [
                                'rgb(255, 99, 132)',
                                'rgb(54, 162, 235)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(153, 102, 255)',
                                'rgb(255, 159, 64)'
                            ],
                borderWidth: 1
            }]
        };

        const genderConfig = {
            type: 'bar',
            data: genderData,
            options: {
                responsive: true,
            }
        };

        const genderChart = new Chart(
            document.getElementById('genderChart'),
            genderConfig
        );
    </script>
</body>

</html>