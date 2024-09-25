<div class="navbar_all">
    <div class="logo"></div>
    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i>

    </button>

    <div class="mobile">
    <a href="teacher_dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'teacher_dashboard.php' ? 'active' : ''; ?>">
    <i class="fa-solid fa-house"></i> Dashboard
    </a>
    <a href="register_student.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'register_student.php' ? 'active' : ''; ?>">
        <i class="fas fa-user-plus"></i> Register Students
    </a>
    <a href="view_students.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'view_students.php' ? 'active' : ''; ?>">
        <i class="fas fa-users"></i> View Students
    </a>
    <a href="create_quiz.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'create_quiz.php' ? 'active' : ''; ?>">
        <i class="fas fa-pencil-alt"></i> Create a Quiz
    </a>
    <!-- <a href=""><i class='bx bx-chart'></i> Students Marks</a>
    <a href=""><i class='bx bx-log-out'></i> Logout</a> -->
</div>




</div>
    <script>
        // Get the button and sidebar elements
        var toggleButton = document.getElementById("toggleButton");
        var sidebar = document.querySelector(".mobile");
        var icon = toggleButton.querySelector("i");

        // Add click event listener to the button
        toggleButton.addEventListener("click", function() {
            // Toggle the visibility of the sidebar
            if (sidebar.style.display === "none" || sidebar.style.display === "") {
                sidebar.style.display = "flex";
                sidebar.style.flexDirection = "column";
                icon.classList.remove("fa-bars-staggered");
                icon.classList.add("fa-xmark");
            } else {
                sidebar.style.display = "none";
                icon.classList.remove("fa-xmark");
                icon.classList.add("fa-bars-staggered");
            }
        });
    </script>