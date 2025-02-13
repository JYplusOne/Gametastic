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

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include the necessary database connection and query for user data

$host = "localhost";
$username = "root";
$password = "";
$database = "gametastic";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted for updating user profile
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    if ($_POST["submit"] === "save") {
        // Save the updated profile information to the database
        $update_query = "UPDATE users SET first_name = ?, last_name = ?, email = ?, phone_number = ?, friends = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssssi", $_POST["firstName"], $_POST["lastName"], $_POST["email"], $_POST["phoneNumber"], $_POST["friends"], $user_id);
        $stmt->execute();
        $stmt->close();

        // Handle profile picture update if a new file is uploaded
        if ($_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            // File upload is successful, process it
            $file = $_FILES['profile_picture'];

            // Define the directory where you want to store uploaded files (current directory)
            $uploadDir = './user_profile_picture/';

            // Ensure the directory exists, create it if not
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate a unique name for the uploaded file to prevent overwriting
            $uploadFile = $uploadDir . basename($file['name']);

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                // File uploaded successfully, and $uploadFile contains the file's path
                // Update the profile picture in the database
                $update_picture_query = "UPDATE users SET profile_picture = ? WHERE id = ?";
                $stmt = $conn->prepare($update_picture_query);
                $stmt->bind_param("si", $uploadFile, $user_id);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Redirect back to the profile page
        header("Location: profile.php");
        exit();
    }
}

// Retrieve user profile information
$query = "SELECT username, first_name, last_name, email, phone_number, friends, profile_picture FROM users WHERE id = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($username, $first_name, $last_name, $email, $phone_number, $friends, $profile_picture);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Gametastic.ico" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
    <title>Profile</title>
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
                    echo '<a href="profile.php"><img src="' . $profile_picture . '" alt="Profile Picture" class="profile-image"></a>';
                    echo '<form method="post" action="profile.php" style="display: inline;">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" id="logoutButton">Logout</button>
                          </form>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="profileform">
        <form action="profile.php" method="POST" enctype="multipart/form-data">
            <div class="input-row">
                <div class="profile-image-container">
                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-image-big" id="profileImage">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/jpg, image/jpeg, image/png" style="display: none;">
                    <label for="profile_picture" id="uploadLabel" style="display: none;">Change Profile Picture</label>
                    <div class="username-container">
                        <input type="text" name="username" id="username-profile" value="<?php echo $username; ?>" readonly>
                    </div>
                </div>   
            </div>
            <div class="input-row">
                <div class="inputbox">
                    <label for="firstName">First Name:</label>
                    <input type="text" name="firstName" id="firstName" value="<?php echo $first_name; ?>" readonly>
                </div>
                <div class="inputbox">
                    <label for="lastName">Last Name:</label>
                    <input type="text" name="lastName" id="lastName" value="<?php echo $last_name; ?>" readonly>
                </div>
            </div>
            <div class="input-row">
                <div class="inputbox">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>" readonly>
                </div>
                <div class="inputbox">
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="tel" name="phoneNumber" id="phoneNumber" value="<?php echo $phone_number; ?>" readonly>
                </div>
            </div>
            <div class="inputbox">
                <label for="friends">Friends (comma-separated):</label>
                <input type="text" name="friends" id="friends" value="<?php echo $friends; ?>" readonly>
            </div>
            <div class="buttonrow">
                <button type="button" id="editButton" onclick="enableEditing()">Edit</button>
                <button type="submit" name="submit" id="saveButton" value="save" style="display: none;">Save</button>
            </div>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <div class="info">
            <div class="footer-logo">
                <a href="index.php"><img src="img/logo.png" alt="Logo"></a>
                <h4><i>"Gametastic: Where Every Game is a Friendship Adventure!"</i></h4>
            </div>
            <div class="footer-links">
                <h4>Useful Links</h4>
                <a href="index.php">Home</a><br>
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

    <!-- JavaScript for enabling editing of user information -->
    <script>
        function enableEditing() {
            document.getElementById('firstName').readOnly = false;
            document.getElementById('lastName').readOnly = false;
            document.getElementById('email').readOnly = false;
            document.getElementById('phoneNumber').readOnly = false;
            document.getElementById('friends').readOnly = false;
            document.getElementById('profile_picture').style.display = 'inline';
            document.getElementById('uploadLabel').style.display = 'inline';

            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'inline';
        }
    </script>
</body>
</html>