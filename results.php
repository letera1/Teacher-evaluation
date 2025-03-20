<?php
// Include database connection
$servername = "localhost";
$username = "root";  
$password = "";      
$dbname = "teach";   

$conn = new mysqli($servername, $username, $password, $dbname);

// Query to fetch all evaluations from the database
$sql = "SELECT teacher_name, course_name, evaluation_score FROM evaluations";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluation Results</title>

    <!-- Custom styles -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
            font-size: 16px;
        }

        td {
            font-size: 14px;
            color: #555;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #ff6f61;
        }

        /* Responsive table */
        @media screen and (max-width: 768px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
            }
            th, td {
                font-size: 12px;
                padding: 10px;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Evaluation Results For computer science teachers </h2>

        <?php
        if ($result->num_rows > 0) {
            // Start the table
            echo "<table>";
            echo "<thead>
                    <tr>
                        <th>Teacher Name</th>
                        <th>Course Name</th>
                        <th>Evaluation Score</th>
                    </tr>
                  </thead><tbody>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['teacher_name']) . "</td>
                        <td>" . htmlspecialchars($row['course_name']) . "</td>
                        <td>" . htmlspecialchars($row['evaluation_score']) . "</td>
                      </tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='no-data'>No evaluations found.</div>";
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
