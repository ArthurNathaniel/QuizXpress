<div class="navbar_all">
    <a href="index.php">
        <div class="logo">

        </div>
    </a>
    <div class="nav_links">
        <a href="">About QuizXpress</a>
        <a href="teacher_login.php">Login as Teacher</a>
        <a href="">Login as Student</a>
    </div>

    <div class="call">
        <div class="call_icons">
            <h1><i class="fa-solid fa-phone"></i></h1>
        </div>
<div class="call_info">
<p>+233 24 363 6672</p>
<span>Call to Question</span>
</div>
    </div>


    <button id="toggleButton">
        <i class="fa-solid fa-bars-staggered"></i>
    </button>
    <div class="mobile">
    <a href="">About QuizXpress</a>
        <a href="">Login as Teacher</a>
        <a href="">Login as Student</a>
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