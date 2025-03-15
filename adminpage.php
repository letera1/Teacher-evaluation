<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f4f4f4;
        }
        .header {
            width: 100%;
            height: 60px;
            background: #007bff;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }
        .header h1 {
            font-size: 22px;
        }
        .header .profile {
            display: flex;
            align-items: center;
        }
        .header .profile a {
            color: white;
            text-decoration: none;
            font-size: 16px;
            margin-left: 15px;
            padding: 5px 10px;
            border-radius: 5px;
            background: #0056b3;
            transition: background 0.3s;
        }
        .header .profile a:hover {
            background: #003d82;
        }
        .main-container {
            display: flex;
            height: 100vh;
            margin-top: 60px;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #007bff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            transition: width 0.3s ease;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 90%;
            padding: 15px;
            color: white;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .sidebar a:hover {
            background: #0056b3;
        }
        .content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        iframe {
            width: 100%;
            height: 100vh;
            border: none;
        }
        .toggle-btn {
            display: none;
            position: absolute;
            top: 70px;
            left: 10px;
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 18px;
            cursor: pointer;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            .toggle-btn {
                display: block;
            }
            .sidebar.open {
                width: 250px;
            }
            .header h1 {
                font-size: 18px;
            }
        }
    </style>
    <script>
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('open');
        }
    </script>
</head>
<body>
    <!-- Header Section -->
    <div class="header">
        <h1>Admin Dashboard</h1>
        <div class="profile">
            <span>👤 Admin</span>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- Main Container (Sidebar + Content) -->
    <div class="main-container">
        <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
        <div class="sidebar">
            <a href="registerdStudent.php" target="contentFrame">Registered Students</a>
            <a href="results.php" target="contentFrame">Evaluation Results</a>
            <a href="adminDb.php" target="contentFrame">Manage Teachers</a>
        </div>
        <div class="content">
            <iframe name="contentFrame" src="welcome.php"></iframe>
        </div>
    </div>
</body>
</html>
