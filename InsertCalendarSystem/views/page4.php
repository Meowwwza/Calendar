<?php
// เชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dw";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่า kuSubjectId มาหรือไม่
if (isset($_GET['kuSubjectId'])) {
    $kuSubjectId = $_GET['kuSubjectId'];

    // สร้างคำสั่ง SQL
    $sql = "SELECT kuId, COUNT(*) as W FROM student 
            NATURAL JOIN fact3_grade
            NATURAL JOIN subject
            NATURAL JOIN subjectgroup
            NATURAL JOIN semester
            WHERE subjectgroup.groupType = 1 
            AND gradeAlias = 'W' 
            AND subject.kuSubjectId = ? 
            GROUP BY kuId  
            ORDER BY kuId ASC";

    // เตรียมคำสั่ง SQL
    $stmt = $conn->prepare($sql);
    // ผูกค่าในคำสั่ง SQL
    $stmt->bind_param("s", $kuSubjectId);
    // ประมวลผลคำสั่ง SQL
    $stmt->execute();
    // ผลลัพธ์
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[$row["kuId"]] = $row["W"];
    }

    // ปิด statement
    $stmt->close();
} else {
    // ถ้าไม่มีค่า kuSubjectId ส่งมาให้เป็นข้อมูลว่าง
    $data = array();
}

// สร้างคำสั่ง SQL เพื่อดึงรายวิชา
$sql_subjects = "SELECT kuSubjectId FROM subject NATURAL JOIN subjectgroup WHERE subjectgroup.groupType = 1";
$result_subjects = $conn->query($sql_subjects);

// เก็บข้อมูลรายวิชาไว้ในตัวแปร
$subjects = array();
if ($result_subjects->num_rows > 0) {
    while ($row_subjects = $result_subjects->fetch_assoc()) {
        $subjects[] = $row_subjects["kuSubjectId"];
    }
}

// ปิดการเชื่อมต่อ
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Infographic</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Dropdown list -->
    <form id="myForm">
        <label for="kuSubjectId">เลือกรายวิชาเฉพาะ(ในสาขา)ที่จะดูจำนวนคน Drop:</label>
        <select id="kuSubjectId" name="kuSubjectId">
            <?php
            foreach ($subjects as $subject) {
                // Check if the subject is the selected one
                $selected = ($kuSubjectId == $subject) ? 'selected' : '';
                echo "<option value='$subject' $selected>$subject</option>";
            }
            ?>
        </select>
    </form>

    <canvas id="myChart"></canvas>

    <script>
        document.getElementById('kuSubjectId').addEventListener('change', function (event) {
            var kuSubjectId = this.value;
            // Submit the form when dropdown value changes
            document.getElementById('myForm').submit();
        });

        var data = <?php echo json_encode($data); ?>;
        var labels = Object.keys(data);
        var values = Object.values(data);

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'จำนวนคน Drop วิชาเฉพาะ(ในภาค)',
                    data: values,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>
