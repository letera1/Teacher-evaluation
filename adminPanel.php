<?php
include('database.php');

// Add Teacher functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $course_name = $_POST['course_name'];
    $department = $_POST['department']; // CS, SE, IS, IT

    // Determine the table based on the department
    $table = strtolower($department) . '_teachers';

    // Prepare the SQL query
    $sql = "INSERT INTO $table (teacher_name, course_name) VALUES (?, ?)";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $teacher_name, $course_name);

    // Execute the query
    if ($stmt->execute()) {
        echo "Teacher added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Delete Teacher functionality
if (isset($_GET['delete_id']) && isset($_GET['department'])) {
    $teacher_id = $_GET['delete_id'];
    $department = $_GET['department']; // CS, SE, IS, IT

    // Determine the table based on the department
    $table = strtolower($department) . '_teachers';

    // Prepare the SQL query
    $sql = "DELETE FROM $table WHERE id = ?";

    // Prepare and bind
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $teacher_id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Teacher deleted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Fetch Teachers for the selected department
$department = isset($_GET['department']) ? $_GET['department'] : 'CS';  // Default to CS
$table = strtolower($department) . '_teachers';
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Teacher Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .form-container {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h1>Admin Teacher Management</h1>

<!-- Add Teacher Form -->
<h2>Add Teacher</h2>
<form action="admin_panel.php" method="POST">
    <input type="text" name="teacher_name" placeholder="Enter Teacher's Name" required>
    <input type="text" name="course_name" placeholder="Enter Course Name" required>
    <select name="department" required>
        <option value="CS" <?php echo ($department == 'CS') ? 'selected' : ''; ?>>Computer Science (CS)</option>
        <option value="SE" <?php echo ($department == 'SE') ? 'selected' : ''; ?>>Software Engineering (SE)</option>
        <option value="IS" <?php echo ($department == 'IS') ? 'selected' : ''; ?>>Information Systems (IS)</option>
        <option value="IT" <?php echo ($department == 'IT') ? 'selected' : ''; ?>>Information Technology (IT)</option>
    </select>
    <input type="submit" name="add_teacher" value="Add Teacher">
</form>

<!-- View Teachers Table -->
<h2>Teachers in <?php echo strtoupper($department); ?> Department</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Teacher Name</th>
        <th>Course Name</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['teacher_name']; ?></td>
            <td><?php echo $row['course_name']; ?></td>
            <td>
                <a href="admin_panel.php?delete_id=<?php echo $row['id']; ?>&department=<?php echo $department; ?>">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

<!-- Change Department -->
<h2>Switch Department</h2>
<a href="admin_panel.php?department=CS">View Computer Science Teachers</a><br>
<a href="admin_panel.php?department=SE">View Software Engineering Te

Hayu, [3/2/2025 1:34 PM]
achers</a><br>
<a href="admin_panel.php?department=IS">View Information Systems Teachers</a><br>
<a href="admin_panel.php?department=IT">View Information Technology Teachers</a><br>

</body>
</html>

<?php
$conn->close();
?>