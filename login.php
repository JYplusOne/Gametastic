<?php
session_start();

// Function to log out a user
function logoutUser() {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();
}

// Check if the user clicked the logout button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"]) && $_POST["logout"] == 1) {
    logoutUser();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "gametastic";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $loginUsername = $_POST["loginUsername"];
    $loginPassword = $_POST["loginPassword"];

    $query = "SELECT id, password, profile_picture FROM users WHERE username = ?"; // Change "email" to "username"

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $loginUsername);
        $stmt->execute();
        $stmt->bind_result($user_id, $hashedPassword, $profile_picture);
        $stmt->fetch();
        $stmt->close();

        if ($user_id) {
            if (password_verify($loginPassword, $hashedPassword)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['profile_picture'] = $profile_picture; // Set the profile picture in the session
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['login_error_message'] = "Incorrect username or password.";
            }
        } else {
            $_SESSION['login_error_message'] = "User not found.";
        }
    } else {
        $_SESSION['login_error_message'] = "Database query error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Gametastic.ico" type="image/x-icon">
    <title>Login</title>

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="background2">
    <!-- Navigation Bar -->
    <div class="navbar">
        <div class="navbar-logo">
            <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
        </div>
        <div>
            <a href="index.php">Home</a>
            <a href="#">Games</a>
            <a href="#">Up-Coming Games</a>
            <a href="#">Events</a>
            <?php
                if (isset($_SESSION['user_id'])) {
                    // Display the "Profile" link when the user is logged in
                    echo '<a href="profile.php">Profile</a>';
                }
            ?>
        </div>
        <div class="buttons">
            <?php
                if (isset($_SESSION['user_id'])) {
                    // User is logged in
                    // Display the user's profile picture and the logout button
                    echo '<a href="profile.php"><img src="' . $_SESSION['profile_picture'] . '" alt="Profile Picture" class="profile-image"></a>';
                    echo '<button id="logoutButton">Logout</button>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    <!-- Login Form -->
    <?php
    // Check if there's a login error message
    if (isset($_SESSION['login_error_message'])) {
        echo '<div class="login_error_message">' . $_SESSION['login_error_message'] . '</div>';
        // Clear the login error message from the session
        unset($_SESSION['login_error_message']);
    }
    ?>    
    <div class="loginform">
        <div class="left-column">
            <h1>Login</h1>
            <img src="img/form-decoration.png" alt="form-decoration">
        </div>
        <div class="right-column">
            <form action="login.php" method="POST">
                <div class="inputbox">
                        <label for="loginUsername">Username:</label>
                        <input type="text" name="loginUsername" id="loginUsername" required>
                </div>
                <div class="inputbox">
                    <label for="loginPassword">Password:</label>
                    <input type="password" name="loginPassword" id="loginPassword" required>
                </div>
                <div class="buttonrow">
                    <button type="submit" name="submit" value="login" class="form-loginbtn">LOGIN</button>
                    <a href="signup.php" class="form-signupbtn">Create an Account</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="info">
            <div class="footer-logo">
                <a href="homepage.html"><img src="img/logo.png" alt="Logo"></a>
                <h4><i>"Gametastic: Where Every Game is a Friendship Adventure!"</i></h4>
            </div>
            <div class="footer-links">
                <h4>Useful Links</h4>
                <a href="#">Home</a><br>
                <a href="#">Games</a><br>
                <a href="#">Up-Coming Games</a><br>
                <a href="#">Events</a>
            </div>
            <div class="footer-info">
                <h4>More Info</h4>
                <a href="#">Terms of Service</a><br>
                <a href="#">Privacy Policy</a><br>
                <a href="#">Contact Us</a>
            </div>
            <div class="footer-intouch">
                <h4>Get In Touch</h4>
                <a href="#">Facebook</a><br>
                <a href="#">Instagram</a><br>
                <a href="#">Twitter</a><br>
                <a href="#">LinkedIn</a>
            </div>
        </div>
        <hr>
        <div class="copyright">
            <p>@2023 Gametastic, All Right Reserved</p>
        </div>
    </footer>

    <!-- Include Bootstrap 5 JavaScript and Popper.js (Latest version) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- JavaScript (at the bottom of your HTML file) -->
    <script>
        // Function to update the file name display
        document.getElementById('profile_picture').addEventListener('change', function() {
            var fileInput = document.getElementById('profile_picture');
            var fileNameDisplay = document.getElementById('file_name_display');

            // Check if a file is selected
            if fileInput.files.length > 0 {
                // Display the file name
                fileNameDisplay.innerText = fileInput.files[0].name;
            } else {
                // No file selected
                fileNameDisplay.innerText = "No file selected";
            }
        });
    </script>
    <!-- JavaScript for handling the logout -->
    <script>
        document.getElementById('logoutButton').addEventListener('click', function() {
            // When the "Logout" button is clicked, submit a form to trigger the logout function
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'login.php';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'logout';
            input.value = '1';

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        });
    </script>
</body>
</html>
