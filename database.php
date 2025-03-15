<?php
session_start(); // Start session

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teach";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn’t exist
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    department VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,  
    student_id VARCHAR(50) UNIQUE NOT NULL
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $id = $_POST['id'];
    $full_name = $_POST['name'];
    $email = $_POST['email'];
    $department = strtolower($_POST['department']); // Convert department to lowercase
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

 // Check if email or student ID already exists
    $checkQuery = "SELECT * FROM students WHERE email = ? OR student_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Email or Student ID already exists.";
    } else {
        // Insert user into the database
        $insertQuery = "INSERT INTO students (id, full_name, email, department, password, student_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("isssss", $id, $full_name, $email, $department, $password, $id);

        if ($stmt->execute()) {
            $_SESSION['email'] = $email;
            $_SESSION['department'] = $department;

            // Redirect user to their department page
            switch ($department) {
                case 'cs':
                    header("Location: cs_page.php");
                    break;
                case 'se':
                    header("Location: se_page.php");
                    break;
                case 'it':
                    header("Location: it_page.php");
                    break;
                case 'is':
                    header("Location: is_page.php");
                    break;
                default:
                    echo "Unknown department!";
            }
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
