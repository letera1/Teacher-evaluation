<?php
session_start(); // Start session at the beginning

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teach";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize error messages
$invalidPassword = "";
$invalidEmail = "";

// Handle login request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']); // Remove spaces
    $password = trim($_POST['password']);

    if (empty($email)) {
        $invalidEmail = "Please enter your email.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $invalidEmail = "Invalid email format.";
    }

    if (empty($password)) {
        $invalidPassword = "Please enter your password.";
    }

    if (empty($invalidEmail) && empty($invalidPassword)) {
        // Query to check user credentials
        $query = "SELECT id, full_name, department, password FROM students WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $full_name, $department, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['id'] = $id;
                $_SESSION['full_name'] = $full_name;
                $_SESSION['department'] = $department;

                // Redirect based on department
                switch (strtolower($department)) {
                    case 'cs':
                        header("Location: cs_page.php");
                        break;
                    case 'se':
                        header("Location: se_page.php");
                        break;
                    case 'is':
                        header("Location: is_page.php");
                        break;
                    case 'it':
                        header("Location: it_page.php");
                        break;
                    default:
                        header("Location: default_page.php"); // Fallback page
                        break;
                }
                exit();
            } else {
                $invalidPassword = "Incorrect password. Please try again.";
            }
        } else {
            $invalidEmail = "Email not found. Please check or register.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navigation Bar</title>
  
    <link rel="stylesheet" href="./tyle.css">
    <link rel="stylesheet" href="./footer.css">
    <link rel="stylesheet" href="./style.css">


</head>

<body>
    <style>
        html, body {
    overflow-y: hidden;
}

    </style>
<nav class="navbar">
        <div class="navdiv">
            <div class="logo">
                <img src="./image/HU.png" alt="HU Logo" class="logo-img" />
                <h2>HARAMAYA UNIVERSITY</h2>
            </div>
            <ul>
                <li><a href="./about us page/about us.html">About Us</a></li>
                <li><a href="./contactus">Contact Us</a></li>
            </ul>
        </div>
    </nav>

    <center><section class="bodys">
        <div class="container" id="container">
            <div class="form-container sign-up-container">
                <form action="./database.php" method="POST">
                    <h1>Create Account</h1>
                    <input type="text" name="name" placeholder="Full Name" required><br>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <select name="department" required>
                        <option value="" disabled selected>Select Department</option>
                        <option value="cs">Computer Science</option>
                        <option value="is">Information Systems</option>
                        <option value="se">Software Engineering</option>
                        <option value="it">Information Technology</option>
                    </select><br>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <input type="text" name="id" placeholder="IDNo" required><br>
                    <button type="submit" name="register">Sign Up</button>
                </form>
            </div>

            <div class="form-container sign-in-container">
                <form action="main.php" method="post"> 
                    <h1>Sign in</h1>
                    <input type="email" name="email" placeholder="Email" required>
                    <span style="color: red; font-size: 14px;"><?php echo htmlspecialchars($invalidEmail); ?></span>
                    <input type="password" name="password" placeholder="Password" required>
                    <span style="color: red; font-size: 14px;"><?php echo htmlspecialchars($invalidPassword); ?></span>
                    <a href="forgot_password.php">Forgot your password?</a>
                    <a href="./ad.php">Admin</a>
                    <button name="login" type="submit">Sign In</button>
                </form>
            </div>

            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Welcome!</h1>
                        <p>To keep connected with us please signup with your personal info</p>
                        <button class="ghost" id="signIn">Sign In</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Hello, Student</h1>
                        <p>Enter your personal information and start your evaluation</p>
                        <button class="ghost" id="signUp">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>
    </section> </center>

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
