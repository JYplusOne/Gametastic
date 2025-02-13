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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/Gametastic.ico" type="image/x-icon">
    <title>Home</title>
    
    <!-- Include Bootstrap 5 CSS (Latest version) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- CSS (style.css) -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
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
                    echo '<form method="post" action="index.php" style="display: inline;">
                            <input type="hidden" name="logout" value="1">
                            <button type="submit" button id="logoutButton">Logout</button>
                          </form>';
                } else {
                    // User is not logged in, display login and signup buttons
                    echo '<a href="login.php" class="loginbtn">Login</a>';
                    echo '<a href="signup.php" class="signupbtn">Sign Up</a>';
                }
            ?>
        </div>
    </div>

    

    <!-- The Banner -->
    <header>
        <div class="background3">
            <div class="container-2columns">
                <div class="text">
                    <h1>Explore a World of Multiplayer Excitement!</h1>                 
                    <p>"Welcome to Gametastic, where the thrill of gaming meets the warmth of friendship. Our platform brings players together for exciting multiplayer experiences. Grab your controllers, invite your friends, and let the games begin!"</p><br>
                    <a href="#popularGamesCarousel" class="explorebtn">Explore Games and Play with Friends</a>
                    <br><br>
                </div>
                <div class="image">
                    <img src="img/banner.png" alt="banner">
                </div>
            </div>
            <!--<img class="layer2" src="img/back2.png" alt="back">
            <img class="layer1" src="img/back.png" alt="back">-->
        </div>
    </header>

    
    <main> 
        <!-- About Section --> 
        <h1>--- About ---</h1>
        <div class="about-us-section">
            <div class="about-us-image">
              <img src="img/about-us-image.png" alt="About Us Image">
            </div>
            <div class="about-us-content">
                <h2>About Gamestatic</h2>
                <p>Gametastic is a entertainment web application dedicated to providing the best multiplayer gaming experiences. Our mission is to bring players together, foster a sense of community, and create a platform where friendships are forged through epic battles and shared victories. Let's play together!</p>
            </div>
        </div>

        <!-- Service Section -->
        <h1>--- Our Services ---</h1> 
        <div class="services-section">
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-1.svg" alt="Service Icon 1">
                </div>
                <h3>Multiplayer Games</h3>
                <p>Engage in thrilling multiplayer battles with your friends and relatives.</p>
            </div>
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-2.svg" alt="Service Icon 2">
                </div>
                <h3>Voice and Text Chat</h3>
                <p>Offer integrated voice and text chat features for real-time communication while gaming.</p>
            </div>
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-3.svg" alt="Service Icon 3">
                </div>
                <h3>Community Building</h3>
                <p>Connect with like-minded gamers and build a strong gaming community.</p>
            </div>
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-4.svg" alt="Service Icon 4">
                </div>
                <h3>Technical Support</h3>
                <p>Get expert assistance to ensure a smooth gaming experience.</p>
            </div>
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-5.svg" alt="Service Icon 5">
                </div>
                <h3>Tournaments</h3>
                <p>Compete in thrilling gaming tournaments and prove your skills.</p>
            </div>
            <div class="service-box">
                <div class="icon-wrapper">
                    <img src="img/services-icon-6.svg" alt="Service Icon 6">
                </div>
                <h3>Gamer Resources</h3>
                <p>Access a treasure trove of resources for gaming success.</p>
            </div>
        </div>
        
        <!-- Carousel Slider to display popular multiplayer games on Gametastic --> 
        <h1>--- Popular Games ---</h1>
        <div id="popularGamesCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#popularGamesCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#popularGamesCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
              <button type="button" data-bs-target="#popularGamesCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/game3.jpg" class="d-block w-100" alt="game1">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Boom War Arena</h2>
                        <p>A thrilling web-based multiplayer game that will keep you on the edge of your seat! Engage in heart-pounding battles, strategize with your team, and unleash explosive mayhem in this action-packed arena experience.</p>
                        <br><a href="#" class="playnowbtn">Play with Friends</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/game2.jpg" class="d-block w-100" alt="game2">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Brawl Star</h2>
                        <p>Brawl Stars is a thrilling and action-packed multiplayer game that takes the world of mobile gaming by storm. Set in a vibrant and chaotic universe, Brawl Stars invites players to engage in epic battles, team up with friends, and engage in strategic combat for supremacy.</p>
                        <br><a href="#" class="playnowbtn">Play with Friends</a>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="img/game1.jpg" class="d-block w-100" alt="game1">
                    <div class="carousel-caption d-none d-md-block">
                        <h2>Star Adventure</h2>
                        <p>Embark on an epic cosmic journey in "Star Adventure," an open-world multiplayer game that takes you to the farthest reaches of the universe. As a space explorer, you'll step into the shoes of a fearless interstellar traveler and delve into an awe-inspiring universe filled with endless possibilities.</p>
                        <br><a href="#" class="playnowbtn">Play with Friends</a>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
          
            <!-- Controls -->
            <a class="carousel-control-prev" href="#popularGamesCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#popularGamesCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>

        <!-- Info cards to display upcoming multiplayer games on Gametastic --> 
        <h1>--- Upcoming Games ---</h1>
        <div class="upcoming-games">
            <div class="game-card">
                <img src="img/upcoming1.jpg" alt="Game 1">
                <h4>Galactic Rivals</h4>
                <p>Join epic interstellar battles in this action-packed and immersive space shooter.</p>
                <p><i>Release Date: November 5, 2023</i></p>
            </div>
            <div class="game-card">
                <img src="img/upcoming2.jpg" alt="Game 2">
                <h4>Lost Relics</h4>
                <p>Embark on a quest to uncover ancient treasures in the dark dungeons.</p>
                <p><i>Release Date: November 15, 2023</i></p>
            </div>
            <div class="game-card">
                <img src="img/upcoming3.jpg" alt="Game 3">
                <h4>Mystic Realms Online</h4>
                <p>Explore magical realms and test your powers in an enchanting MMORPG.</p>
                <p><i>Release Date: November 20, 2023</i></p>
            </div>
            <div class="game-card">
                <img src="img/upcoming4.jpg" alt="Game 4">
                <h4>Cyber Strike: Redux</h4>
                <p>Battle in a futuristic world filled with high-tech weaponry and cyber-enhanced soldiers</p>
                <p><i>Release Date: December 10, 2023</i></p>
            </div>
        </div>

    </main>
    
    

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

</body>
</html>