<?php
// Establish a database connection
$host = 'localhost'; // แก้ตาม host ของคุณ
$username = 'root'; // แก้ตาม username ของคุณ
$password = ''; // แก้ตาม password ของคุณ
$database = 'dw'; // แก้ตามชื่อฐานข้อมูลของคุณ

$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Execute the SQL query to fetch data
$sql = "SELECT s.kuId, 
               s.accessionNo, 
               ROUND(AVG(f.gpa), 2) AS avg_gpa, 
               se.semesterYear, 
               COUNT(*) AS count_students,
               ROUND(AVG(f.gpax), 2) AS avg_gpax
        FROM student s 
        JOIN fact2_grade_summary f ON s.studentId = f.studentId 
        JOIN semester se ON f.semesterId = se.semesterId 
        GROUP BY s.kuId, s.accessionNo 
        ORDER BY se.semesterYear ASC";

$result = mysqli_query($connection, $sql);

// Prepare data for Chart.js
$labels = [];
$data = [];
$gpax = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['kuId'] . '-' . $row['accessionNo']; // สำหรับใช้เป็น x-axis labels
    $data[] = $row['avg_gpa']; // สำหรับใช้เป็น y-axis data
    $gpax[] = $row['avg_gpax']; // คะแนน GPAX
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Graph from SQL Data</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        canvas {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 80%; /* ปรับขนาดกราฟให้ไม่ใหญ่เกินไป */
            max-height: 80%; /* ปรับขนาดกราฟให้ไม่ใหญ่เกินไป */
        }
    </style>
</head>
<body>
    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Average GPA',
                    data: <?php echo json_encode($data); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'GPAX',
                    data: <?php echo json_encode($gpax); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
