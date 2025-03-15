<?php
session_start();

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teach";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $input_password = $_POST['password'];

    // Query to fetch the admin user by email
    $sql = "SELECT * FROM admin_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Bind the email parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($input_password, $row['password'])) {
            // If password matches, set session and redirect to example.php
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['email'] = $email;
            header("Location: adminpage.php");
            exit();
        } else {
            // Incorrect password
            $error_message = "Invalid email or password.";
        }
    } else {
        // Email not found in the database
        $error_message = "Invalid email or password.";
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Sign In</title>
    <!-- <link rel="stylesheet" href="style.css" /> -->
    <link rel="stylesheet" href="./tyle.css" />

    <link rel="stylesheet" href="./headeradmin.css">
    <link rel="stylesheet" href="./footer.css">
</head>
<body>

    <nav class="navbar">
        <div class="navdiv">
            <div class="logo">
                <img src="./image/HU.png" alt="HU Logo" class="logo-img" />
                <h2>HARAMAYA UNIVERSITY</h2>
            </div>
            <ul>
                <li><a href="./about us page/about us.html">About Us</a></li>
                <li><a href="#">Contact Us</a></li>
            </ul>
        </div>
    </nav>
    <center>  <div class="container" id="container">
        <div class="form-container sign-in-container">
            <div class="login-container">
                <form class ="adminsignform"action="ad.php" method="post">
                    <h1>Sign in</h1>

                    <!-- Show error message if there is one -->
                    <?php if (isset($error_message)) { echo '<p class="error">' . $error_message . '</p>'; } ?>

                    <input type="email" name="email" placeholder="Email" required />
                    <input type="password" name="password" placeholder="Password" required />
                    
                    <a href="#">Forgot your password?</a>
                    <a href="./main.php">Student</a>
                    <button type="submit" class="btn">Sign In</button>
                </form>
            </div>
        </div>

        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Admin</h1>
                    <p>Enter your personal information and check student evaluation form</p>
                </div>
            </div>
        </div>
    </div></center>
  

    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-middle">
                <h3>For More Information</h3>
                <p>Email: haramaya@haramaya.edu.et</p>
                <p>Phone: +251(0) 255530319</p>
                <p>Address: Bate, Haramaya, Ethiopia</p>
            </div>
            <div class="copyright">
                <strong>
                    Copyright &copy; <span id="current-year">2025</span>
                    <a href="https://www.haramaya.edu.et" target="_blank">Haramaya University</a>
                </strong>
                All rights reserved.
            </div>
        </div>
    </footer>

    <script src="./script.js"></script>

</body>
</html>
