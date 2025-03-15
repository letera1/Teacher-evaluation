<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teach"; // Include database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

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
            echo "Invalid password!";
        }
    } else {
        echo "User not found!";
    }

    $stmt->close();
}
?>
