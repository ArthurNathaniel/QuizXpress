<?php
include 'db.php';

// Fetch registered teachers from the database
$teachers_result = $conn->query("SELECT * FROM teachers");

// Fetch classes and subjects for dropdowns
$classes_result = $conn->query("SELECT class_name FROM classes");
$subjects_result = $conn->query("SELECT subject_name FROM subjects");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Registered Teachers - QuizXpress</title>
    <link rel="stylesheet" href="./css/base.css">
    <link rel="stylesheet" href="./css/teacher.css">
</head>
<body>
    <div class="registered_teachers_all">
        <h2>Registered Teachers</h2>
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Gender</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $teachers_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['class']); ?></td>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td>
                            <button class="button button-primary" onclick="document.getElementById('editModal<?php echo $row['id']; ?>').style.display='block'">Edit</button>
                            <button class="button button-danger" onclick="document.getElementById('deleteModal<?php echo $row['id']; ?>').style.display='block'">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Modal -->
                    <div class="modal" id="editModal<?php echo $row['id']; ?>">
                        <div class="modal-content">
                            <span class="close" onclick="document.getElementById('editModal<?php echo $row['id']; ?>').style.display='none'">&times;</span>
                            <form action="update_teacher.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div>
                                    <label for="full_name">Full Name:</label>
                                    <input type="text" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" required>
                                </div>
                                <div>
                                    <label for="email">Email:</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                </div>
                                <div>
                                    <label for="class">Class:</label>
                                    <select name="class" required>
                                        <?php while ($class_row = $classes_result->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($class_row['class_name']); ?>"
                                                <?php if ($row['class'] == $class_row['class_name']) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($class_row['class_name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="subject">Subject:</label>
                                    <select name="subject" required>
                                        <?php while ($subject_row = $subjects_result->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($subject_row['subject_name']); ?>"
                                                <?php if ($row['subject'] == $subject_row['subject_name']) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($subject_row['subject_name']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="gender">Gender:</label>
                                    <select name="gender" required>
                                        <option value="Male" <?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                                        <option value="Female" <?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                                    </select>
                                </div>
                                <div>
                                    <button type="submit" class="button button-primary">Save changes</button>
                                    <button type="button" class="button button-danger" onclick="document.getElementById('editModal<?php echo $row['id']; ?>').style.display='none'">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal" id="deleteModal<?php echo $row['id']; ?>">
                        <div class="modal-content">
                            <span class="close" onclick="document.getElementById('deleteModal<?php echo $row['id']; ?>').style.display='none'">&times;</span>
                            <div>
                                <p>Are you sure you want to delete this teacher?</p>
                                <form action="delete_teacher.php" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="button" class="button button-danger" onclick="document.getElementById('deleteModal<?php echo $row['id']; ?>').style.display='none'">Cancel</button>
                                    <button type="submit" class="button button-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                <?php endwhile; ?>
            </tbody>
        </table>
        <p><a href="admin_dashboard.php" class="button button-secondary">Back to Dashboard</a></p>
    </div>

    <script>
        // Close modals if clicked outside of them
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = "none";
                }
            }
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
