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
    echo "unable to connect";
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all students
$query = "SELECT id, full_name, email, department, student_id FROM students";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Registered Students</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFC;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Registered Students</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Department</th>
            <th>Student ID</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['department']}</td>
                        <td>{$row['student_id']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No students registered.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>
