<?php
include 'db.php';

// Fetch students from the database
$students_result = $conn->query("SELECT * FROM students ORDER BY created_at DESC");

// Fetch classes from the database
$classes_result = $conn->query("SELECT * FROM classes ORDER BY class_name ASC");

// Store all classes in an array to use later
$classes = [];
while ($class_row = $classes_result->fetch_assoc()) {
    $classes[] = $class_row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students - QuizXpress</title>
    <?php include 'cdn.php' ?>
    <!-- <link rel="stylesheet" href="./css/base.css"> -->
    <link rel="stylesheet" href="./css/teacher.css">
    <link rel="stylesheet" href="./css/students.css">
</head>
<body>
<?php include 'teachers_navbar.php' ?>
    <div class="view_students_all">
        <h2>View Students</h2>
        <table>
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Full Name</th>
                    <th>Gender</th>
                    <th>Class</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $students_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['student_id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['class']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class="action_btn">
                        <button onclick="openModal('editModal<?php echo $row['id']; ?>')"><i class="fa-solid fa-user-pen"></i></button>
                        <button class="delete" onclick="openModal('deleteModal<?php echo $row['id']; ?>')"><i class="fa-solid fa-trash"></i></button>
                    </td>
                </tr>

                <!-- Edit Student Modal -->
                <div id="editModal<?php echo $row['id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('editModal<?php echo $row['id']; ?>')">&times;</span>
                        <div class="logo"></div>
                        <div class="forms">
                        <hr>
                    </div>
                        <div class="forms">
                        <h2>Edit Student</h2>
                        </div>
                 

                        <form action="edit_student.php" method="POST">
                            <div class="forms">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="text" class="form-control" name="full_name" value="<?php echo $row['full_name']; ?>" required>
                            </div>
                          <div class="forms">
                          <select class="form-control" name="gender" required>
                                <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            </select>
                          </div>
                            <div class="forms">
                            <select class="form-control" name="class" required>
                                <?php foreach ($classes as $class_row): ?>
                                    <option value="<?php echo $class_row['class_name']; ?>" <?php echo ($row['class'] == $class_row['class_name']) ? 'selected' : ''; ?>>
                                        <?php echo $class_row['class_name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            </div>
                            <div class="forms">
                            <input type="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" required>
                            </div>
                           <div class="forms">
                           <input type="password" class="form-control" name="password" placeholder="Password (leave blank to keep unchanged)">
                           </div>
                          <div class="forms">
                          <button type="submit">Save changes</button>
                          </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Student Modal -->
                <div id="deleteModal<?php echo $row['id']; ?>" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal('deleteModal<?php echo $row['id']; ?>')">&times;</span>
                        <h2>Delete Student</h2>
                        <p>Are you sure you want to delete this student?</p>
                        <form action="delete_student.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete">Delete</button>
                            <button type="button" onclick="closeModal('deleteModal<?php echo $row['id']; ?>')">Cancel</button>
                        </form>
                    </div>
                </div>

                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
        }
    </script>
</body>
</html>
