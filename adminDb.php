<?php
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "teach";   // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a unified teachers table if not exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(100) NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    department ENUM('CS', 'SE', 'IS', 'IT') NOT NULL
)";

if (!$conn->query($sql_create_table)) {
    die("Error creating table: " . $conn->error);
}

// Insert teacher data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $course_name = $_POST['course_name'];
    $department = $_POST['department'];

    $sql = "INSERT INTO teachers (teacher_name, course_name, department) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $teacher_name, $course_name, $department);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Teacher added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Retrieve teachers grouped by department
$departments = ["CS" => "Computer Science", "SE" => "Software Engineering", "IS" => "Information Systems", "IT" => "Information Technology"];
$teachers_by_department = [];

foreach ($departments as $code => $name) {
    $sql = "SELECT * FROM teachers WHERE department = '$code'";
    $result = $conn->query($sql);
    $teachers_by_department[$code] = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        .department-section {
            margin-bottom: 30px;
        }
        .department-title {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin-top: 20px;
            border-radius: 5px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input, select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .search-box {
            padding: 10px;
            margin-bottom: 10px;
            width: 100%;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        @media (max-width: 600px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Add Teacher</h2>
    <form method="POST">
        <input type="text" name="teacher_name" placeholder="Teacher Name" required>
        <input type="text" name="course_name" placeholder="Course Name" required>
        <select name="department" required>
            <option value="" disabled selected>Select Department</option>
            <option value="CS">Computer Science</option>
            <option value="SE">Software Engineering</option>
            <option value="IS">Information Systems</option>
            <option value="IT">Information Technology</option>
        </select>
        <button type="submit" name="add_teacher">Add Teacher</button>
    </form>

    <h2>Teachers List</h2>

    <?php foreach ($departments as $code => $name): ?>
        <div class="department-section">
            <h3 class="department-title"><?= $name ?></h3>
            <input type="text" class="search-box" placeholder="Search in <?= $name ?>" onkeyup="filterTable(this, 'table-<?= $code ?>')">
            <table id="table-<?= $code ?>">
                <tr>
                    <th onclick="sortTable('table-<?= $code ?>', 0)">ID ▲</th>
                    <th onclick="sortTable('table-<?= $code ?>', 1)">Teacher Name ▲</th>
                    <th onclick="sortTable('table-<?= $code ?>', 2)">Course Name ▲</th>
                </tr>
                <?php if (!empty($teachers_by_department[$code])): ?>
                    <?php foreach ($teachers_by_department[$code] as $teacher): ?>
                        <tr>
                            <td><?= $teacher["id"] ?></td>
                            <td><?= htmlspecialchars($teacher["teacher_name"]) ?></td>
                            <td><?= htmlspecialchars($teacher["course_name"]) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No teachers in this department</td></tr>
                <?php endif; ?>
            </table>
        </div>
    <?php endforeach; ?>
</div>

<script>
    function filterTable(input, tableId) {
        let filter = input.value.toLowerCase();
        let table = document.getElementById(tableId);
        let rows = table.getElementsByTagName("tr");

        for (let i = 1; i < rows.length; i++) {
            let cells = rows[i].getElementsByTagName("td");
            let found = false;
            for (let j = 0; j < cells.length; j++) {
                if (cells[j].textContent.toLowerCase().includes(filter)) {
                    found = true;
                    break;
                }
            }
            rows[i].style.display = found ? "" : "none";
        }
    }

    function sortTable(tableId, columnIndex) {
        let table = document.getElementById(tableId);
        let rows = Array.from(table.rows).slice(1);
        rows.sort((a, b) => a.cells[columnIndex].textContent.localeCompare(b.cells[columnIndex].textContent));
        rows.forEach(row => table.appendChild(row));
    }
</script>

</body>
</html>

<?php
$conn->close();
?>
