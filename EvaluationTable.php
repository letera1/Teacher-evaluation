 <!-- for storing   -->
  <?php
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

// Create table if not exists


$sql = "CREATE TABLE IF NOT EXISTS evaluations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_name VARCHAR(255) NOT NULL,
    course_name VARCHAR(255) NOT NULL,
    evaluation_score FLOAT NOT NULL
)";

// nama 

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $teacher_name = $_GET['teacher_name'];
    $course_name = $_GET['course_name'];
    $total_score = 0; // Initialize total_score
    $evaluation_score = 0; // Initialize evaluation_score
    
    // Loop through each row and calculate total_score
    for ($i = 1; $i <= 22; $i++) {  // Update to loop through all 22 rows
        if (isset($_GET['row' . $i])) {
            $selected_value = $_GET['row' . $i];
            if (is_numeric($selected_value)) { // Ensure it's a valid numeric value
                $total_score += intval($selected_value); 
                 // Add the value to the total score
              
            }
        }
    }
    
    // Calculate evaluation_score only if total_score is not zero
    if ($total_score > 0) {
        $evaluation_score = $total_score / 22; // Normalize score
    }

    // Insert into database if there's a valid score
    $stmt = $conn->prepare("INSERT INTO evaluations (teacher_name, course_name, evaluation_score) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $teacher_name, $course_name, $evaluation_score);
    
    if ($stmt->execute()) {
        echo "Evaluation submitted successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSTRUCTOR EVALUATION REPORT</title>
      <link rel="stylesheet" href="./evaluation.css">


   

</head>

<body>
    <header>
        <div class="Home">
            <img src="Image/HU.png" alt="hu photo">
            <h2>Home</h2>
        </div>
        <div>
           <P style="text-align: center; background-color:green;padding: 5px 5px 5px;">INSTRUCTOR EVALUATION REPORT</P>
        </div>
        <nav>
            <ul>
                <li> <a href="./contactus">contact</a></li>
                <li><a href="./about us page/about us.html">About</a></li>
              
</ul>
        </nav>
    </header>
    <form action="" method="GET" onsubmit="handleSubmit(event)">
        <div class="table-container">
        <p><strong>Teacher Name: <?= htmlspecialchars($teacher_name) ?>  <span> | Course Name: <?= htmlspecialchars($course_name) ?></span></strong></p>
        <input type="hidden" name="teacher_name" value="<?= htmlspecialchars($teacher_name) ?>">
<input type="hidden" name="course_name" value="<?= htmlspecialchars($course_name) ?>">
        <table style="width: 90%; margin-right: 25%;" class="wholeTable">
                <tr>
                    <td colspan="6" style="text-align: center;">OVERALL INSTRUCTOR PERFORMANCE</td>
                    <td class="result">x/5</td>
                </tr>
                <tr>
                    <td rowspan="2">NO.</td>
                    <td rowspan="2">Question</td>

                    <td>Strong Agree</td>
                    <td>Agree</td>
                    <td>Moderate</td>
                    <td>Disagree</td>
                    <td>Strongly Disagree</td>
                </tr>
                <tr>
                    
                   
                    <td>5</td>
                    <td>4</td>
                    <td>3</td>
                    <td>2</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Respected the principle of day-one-class-one (DOCO) and used all allotted time for
                        teaching/instruction</td>
                    <td><input type="radio" name="row1" value="5"></td>
                    <td><input type="radio" name="row1" value="4"></td>
                    <td><input type="radio" name="row1" value="3"></td>
                    <td><input type="radio" name="row1" value="2"></td>
                    <td><input type="radio" name="row1" value="1"></td>


                </tr>
                <tr>
                    <td>2</td>
                    <td> Used to come to class well prepared and organized to teach the course.</td>
                    <td><input type="radio" name="row2" value="5"></td>
                    <td><input type="radio" name="row2" value="4"></td>
                    <td><input type="radio" name="row2" value="3"></td>
                    <td><input type="radio" name="row2" value="2"></td>
                    <td><input type="radio" name="row2" value="1"></td>




                </tr>
                <tr>
                    <td>3</td>
                    <td> Gave a complete course outline during the first week of beginning teaching in class</td>
                    <td><input type="radio" name="row3" value="5"></td>
                    <td><input type="radio" name="row3" value="4"></td>
                    <td><input type="radio" name="row3" value="3"></td>
                    <td><input type="radio" name="row3" value="2"></td>
                    <td><input type="radio" name="row3" value="1"></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td> Supported theoretical teaching in class with practical skills</td>
                    <td><input type="radio" name="row4" value="5"></td>
                    <td><input type="radio" name="row4" value="4"></td>
                    <td><input type="radio" name="row4" value="3"></td>
                    <td><input type="radio" name="row4" value="2"></td>
                    <td><input type="radio" name="row4" value="1"></td>


                </tr>
                <tr>


                    <td>5</td>
                    <td> Used appropriate instructional methods and teaching aids as required</td>
                    <td><input type="radio" name="row5" value="5"></td>
                    <td><input type="radio" name="row5" value="4"></td>
                    <td><input type="radio" name="row5" value="3"></td>
                    <td><input type="radio" name="row5" value="2"></td>
                    <td><input type="radio" name="row5" value="1"></td>
                </tr>


                <tr>
                    <td>6</td>
                    <td> Used only English as a medium of instruction rather than local language.</td>
                    <td><input type="radio" name="row6" value="5"></td>
                    <td><input type="radio" name="row6" value="4"></td>
                    <td><input type="radio" name="row6" value="3"></td>
                    <td><input type="radio" name="row6" value="2"></td>
                    <td><input type="radio" name="row6" value="1"></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td> Motivated students to ask questions and give comments in class</td>
                    <td><input type="radio" name="row7" value="5"></td>
                    <td><input type="radio" name="row7" value="4"></td>
                    <td><input type="radio" name="row7" value="3"></td>
                    <td><input type="radio" name="row7" value="2"></td>
                    <td><input type="radio" name="row7" value="1"></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td> Showed a strong motivation to teach and make students gain knowledge and skills.</td>
                    <td><input type="radio" name="row8" value="5"></td>
                    <td><input type="radio" name="row8" value="4"></td>
                    <td><input type="radio" name="row8" value="3"></td>
                    <td><input type="radio" name="row8" value="2"></td>
                    <td><input type="radio" name="row8" value="1"></td>
                </tr>

                <td>9</td>
                <td> Focused on the subject matter in class and did not digress or divert the topic to irrelevant issues
                <td><input type="radio" name="row9" value="4"></td>
                <td><input type="radio" name="row9" value="3"></td>
                <td><input type="radio" name="row9" value="2"></td>
                <td><input type="radio" name="row9" value="1"></td>
                <td><input type="radio" name="row9" value="1"></td>

                </td>
                <tr>
                    <td>10</td>
                    <td> Gave exercises/assignments/term papers for continuous assessment</td>
                    <td><input type="radio" name="row10" value="5"></td>
                    <td><input type="radio" name="row10" value="4"></td>
                    <td><input type="radio" name="row10" value="3"></td>
                    <td><input type="radio" name="row10" value="2"></td>
                    <td><input type="radio" name="row10" value="1"></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td> Set conceptual exam questions that promote critical thinking rather than promoting rote
                        learning.
                    </td>

                    <td><input type="radio" name="row11" value="5"></td>
                    <td><input type="radio" name="row11" value="4"></td>
                    <td><input type="radio" name="row11" value="3"></td>
                    <td><input type="radio" name="row11" value="2"></td>
                    <td><input type="radio" name="row11" value="1"></td>

                </tr>
                <tr>
                    <td>12</td>
                    <td>Set exam questions that are related to the topics covered in class and according to the syllabus
                    </td>
                    <td><input type="radio" name="row12" value="5"></td>
                    <td><input type="radio" name="row12" value="4"></td>
                    <td><input type="radio" name="row12" value="3"></td>
                    <td><input type="radio" name="row12" value="2"></td>
                    <td><input type="radio" name="row12" value="1"></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td> Set conceptual exam questions that promote critical thinking rather than promoting rote
                        learning</td>
                    <td><input type="radio" name="row13" value="5"></td>
                    <td><input type="radio" name="row13" value="4"></td>
                    <td><input type="radio" name="row13" value="3"></td>
                    <td><input type="radio" name="row13" value="2"></td>
                    <td><input type="radio" name="row13" value="1"></td>
                </tr>
                <tr>
                    <td>14</td>
                    <td>Showed students their exam results and gave feedback.</td>
                    <td><input type="radio" name="row14" value="5"></td>
                    <td><input type="radio" name="row14" value="4"></td>
                    <td><input type="radio" name="row14" value="3"></td>
                    <td><input type="radio" name="row14" value="2"></td>
                    <td><input type="radio" name="row14" value="1"></td>

                </tr>
                <tr>
                    <td>15</td>
                    <td> Has sufficient knowledge and confidence in the subject matter of the course he/she taught</td>
                    <td><input type="radio" name="row15" value="5"></td>
                    <td><input type="radio" name="row15" value="4"></td>
                    <td><input type="radio" name="row15" value="3"></td>
                    <td><input type="radio" name="row15" value="2"></td>
                    <td><input type="radio" name="row15" value="1"></td>
                </tr>
                <tr>
                    <td>16</td>
                    <td>Did not demoralize, lampoon, embarrass or insult students or use bad language against them.</td>
                    <td><input type="radio" name="row16" value="5"></td>
                    <td><input type="radio" name="row16" value="4"></td>
                    <td><input type="radio" name="row16" value="3"></td>
                    <td><input type="radio" name="row16" value="2"></td>
                    <td><input type="radio" name="row16" value="1"></td>

                </tr>
                <tr>
                    <td>17</td>
                    <td>Delivered the subject matter of the course clearly in a way that students understood</td>
                    <td><input type="radio" name="row17" value="5"></td>
                    <td><input type="radio" name="row17" value="4"></td>
                    <td><input type="radio" name="row17" value="3"></td>
                    <td><input type="radio" name="row17" value="2"></td>
                    <td><input type="radio" name="row17" value="1"></td>

                </tr>
                <tr>
                    <td>18</td>
                    <td>Was punctual or came to class in time and left class after using all his/her time.</td>
                    <td><input type="radio" name="row18" value="5"></td>
                    <td><input type="radio" name="row18" value="4"></td>
                    <td><input type="radio" name="row18" value="3"></td>
                    <td><input type="radio" name="row18" value="2"></td>
                    <td><input type="radio" name="row18" value="1"></td>
                </tr>
                <tr>
                    <td>19</td>
                    <td>Did not miss normal class schedules and bother students with make-up classes.</td>
                    <td><input type="radio" name="row19" value="5"></td>
                    <td><input type="radio" name="row19" value="4"></td>
                    <td><input type="radio" name="row19" value="3"></td>
                    <td><input type="radio" name="row19" value="2"></td>
                    <td><input type="radio" name="row19" value="1"></td>
                </tr>
                <tr>
                    <td>20</td>
                    <td>Covered the whole topics of the course according to the syllabus.</td>
                    <td><input type="radio" name="row20" value="5"></td>
                    <td><input type="radio" name="row20" value="4"></td>
                    <td><input type="radio" name="row20" value="3"></td>
                    <td><input type="radio" name="row20" value="2"></td>
                    <td><input type="radio" name="row20" value="1"></td>
                </tr>
                <tr>
                    <td>21</td>
                    <td> Treated students fairly and equitably, without any discrimination on any grounds whatsoever.
                    </td>
                    <td><input type="radio" name="row21" value="5"></td>
                    <td><input type="radio" name="row21" value="4"></td>
                    <td><input type="radio" name="row21" value="3"></td>
                    <td><input type="radio" name="row21" value="2"></td>
                    <td><input type="radio" name="row21" value="1"></td>
                </tr>
                <tr>
                    <td>22</td>
                    <td> Dressed appropriately for teaching (wore gowns, etc) and kept a good personal hygiene.</td>
                    <td><input type="radio" name="row22" value="5"></td>
                    <td><input type="radio" name="row22" value="4"></td>
                    <td><input type="radio" name="row22" value="3"></td>
                    <td><input type="radio" name="row22" value="2"></td>
                    <td><input type="radio" name="row22" value="1"></td>
                </tr>
            </table>


        </div>
        <input type="submit" class="submit-btn" value="submit">

    </form>
   
</body>

</html>