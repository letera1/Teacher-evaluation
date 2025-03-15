<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: main.html");
    exit();
}

$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "teach";   

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM teachers WHERE department = 'It'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Science Teachers</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            table {
                border: 0;
                width: 100%;
            }

            th, td {
                display: block;
                width: 100%;
                text-align: right;
            }

            th {
                text-align: left;
                background-color: #f2f2f2;
            }

            td {
                text-align: left;
                padding-left: 50%;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                padding-right: 10px;
                text-transform: uppercase;
            }
        }

        /* Search Box */
        .search-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 8px;
            width: 300px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        /* Button Styles */
        .action-btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }

        .action-btn:hover {
            background-color: #45a049;
        }

        /* Hover effect */
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h2>Computer Science Teachers</h2>

<!-- Search Box -->
<div class="search-container">
    <input type="text" id="searchInput" placeholder="Search for teachers..." onkeyup="filterTable()">
</div>

<table id="teacherTable">
    <thead>
        <tr>
            <th onclick="sortTable(0)">ID</th>
            <th onclick="sortTable(1)">Teacher Name</th>
            <th onclick="sortTable(2)">Course Name</th>
            <th>Action</th> <!-- New column for buttons -->
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["teacher_name"]) ?></td>
                <td><?= htmlspecialchars($row["course_name"]) ?></td>
                <td>
                    <!-- Button added here -->
                    <a href="EvaluationTable.php?teacher_id=<?= $row['id'] ?>&teacher_name=<?= urlencode($row['teacher_name']) ?>&course_name=<?= urlencode($row['course_name']) ?>" class="action-btn">View</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="main.php">Back to Home</a>

<?php $conn->close(); ?>

</body>
</html>
