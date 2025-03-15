<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: main.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Software Engineering Page</title>
</head>
<body>
    <h1>Welcome, Software Engineering Student!</h1>
    <a href="logout.php">Logout</a>
</body>
</html>
