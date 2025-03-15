<?php
// Database connection
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "teach"; 
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create table
$sql = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table admin_users created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}


$email = "admin123@gmail.com";
$password = password_hash("admin123@gmail.com", PASSWORD_DEFAULT); // Hashing the password

// SQL to insert the admin user
$sql = "INSERT INTO admin_users (email, password) VALUES (?, ?)";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $password);

// Execute the query
if ($stmt->execute()) {
    echo "Admin user inserted successfully!";
} else {
    echo "Error inserting admin user: " . $stmt->error;
}




// Close connection
$conn->close();
?>
