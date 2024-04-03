<!DOCTYPE html>
<html>
<head>
    <title>Infographic</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>kuId</th>
                <th>kuSubjectId</th>
                <th>amount_students</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            <?php
            // เชื่อมต่อฐานข้อมูล
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "dw";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // ตรวจสอบการเชื่อมต่อ
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // คำสั่ง SQL
            $sql = "SELECT DISTINCT student.kuId, subject.kuSubjectId, COUNT(DISTINCT(student.studentId)) AS amount_students
                    FROM subject
                    NATURAL JOIN student
                    NATURAL JOIN fact3_grade
                    NATURAL JOIN subjectgroup
                    WHERE subjectGroupId = '4' AND planYear = '1' AND gradeAlias = 'F'
                    GROUP BY subject.kuSubjectId, student.kuId";

            $result = $conn->query($sql);

            // แสดงข้อมูลในตาราง
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['kuId'] . "</td>";
                echo "<td>" . $row['kuSubjectId'] . "</td>";
                echo "<td>" . $row['amount_students'] . "</td>";
                echo "</tr>";
            }

            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();
            ?>
        </tbody>
    </table>

    <canvas id="myChart" width="800" height="400"></canvas>

    <script>
        function randomColor() {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            return `rgba(${r}, ${g}, ${b}, 0.2)`;
        }

        fetch('data.php')
            .then(response => response.json())
            .then(data => {
                const chartData = {};

                data.forEach(row => {
                    if (!chartData[row.kuSubjectId]) {
                        chartData[row.kuSubjectId] = {};
                    }
                    chartData[row.kuSubjectId][row.kuId] = row.amount_students;
                });

                const allKuIds = new Set();
                Object.values(chartData).forEach(subjectData => {
                    Object.keys(subjectData).forEach(kuId => {
                        allKuIds.add(kuId);
                    });
                });

                Object.values(chartData).forEach(subjectData => {
                    allKuIds.forEach(kuId => {
                        if (!subjectData[kuId]) {
                            subjectData[kuId] = 0;
                        }
                    });
                });

                const ctx = document.getElementById('myChart').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: Object.keys(chartData),
                        datasets: Array.from(allKuIds).map(kuId => ({
                            label: `kuId ${kuId}`,
                            data: Object.values(chartData).map(subjectData => subjectData[kuId] || 0),
                            backgroundColor: randomColor(),
                            borderColor: randomColor(),
                            borderWidth: 1
                        }))
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
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    </script>

    <?php
    // เชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dw";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // คำสั่ง SQL
    $sql = "SELECT DISTINCT student.kuId, subject.kuSubjectId, COUNT(DISTINCT(student.studentId)) AS amount_students
            FROM subject
            NATURAL JOIN student
            NATURAL JOIN fact3_grade
            NATURAL JOIN subjectgroup
            WHERE subjectGroupId = '4' AND planYear = '1' AND gradeAlias = 'F'
            GROUP BY subject.kuSubjectId, student.kuId";

    $result = $conn->query($sql);

    $data = array();

    // เก็บข้อมูลลงในรูปแบบของ JSON
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();

    // ส่งข้อมูล JSON กลับ
    echo "<script>const chartData = " . json_encode($data) . ";</script>";
    ?>
</body>
</html>
