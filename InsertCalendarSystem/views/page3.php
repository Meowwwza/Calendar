<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- theme meta -->
    <meta name="theme-name" content="quixlab" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>ระบบเพิ่มรายปฏิทิน</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <!-- Pignose Calender -->
    <link href="./plugins/pg-calendar/css/pignose.calendar.min.css" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="./plugins/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="./plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css">
    <!-- Custom Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
            border: 1px solid #ddd;
            /* เพิ่มเส้นขอบ */
        }

        th,
        td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        canvas {
            width: 100% !important;
            height: 400px !important;
        }
    </style>
</head>

<body>
    <?php
    session_start();
    ?>
    <?php include('./layout.php'); ?>

    <!--**********************************
        Content body start
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-10" style="display: block; justify-content: center; align-items: center;">
                    <div class="card">
                        <div class="card-body">
                            <?php
                            // เชื่อมต่อกับฐานข้อมูล
                            $servername = "localhost";
                            $username = "root";
                            $password = "";
                            $dbname = "dw";

                            $conn = new mysqli($servername, $username, $password, $dbname);

                            // ตรวจสอบการเชื่อมต่อ
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // คิวรี่ SELECT
                            $sql = "SELECT student.kuId, student.accessionNo AS 'รอบที่เข้าเรียน', AVG(fact2_grade_summary.gpa), fact2_grade_summary.subjectGroupId 
                        FROM student 
                        INNER JOIN fact2_grade_summary ON student.studentId = fact2_grade_summary.studentId 
                        INNER JOIN fact3_grade ON student.studentId = fact3_grade.studentId 
                        INNER JOIN subjectgroup ON subjectgroup.subjectGroupId = fact2_grade_summary.subjectGroupId
                         WHERE subjectgroup.subjectGroupId='4' AND subjectgroup.groupType='1' 
                        GROUP BY student.kuId, student.accessionNo 
                        ORDER BY student.kuId ,student.accessionNo ASC;";

                            $result = $conn->query($sql);

                            // ตรวจสอบว่ามีข้อมูลที่คิวรี่ได้หรือไม่
                            if ($result->num_rows > 0) {
                                // สร้างอาร์เรย์ของข้อมูลสำหรับแผนภูมิ
                                $kuIds = [];
                                $accessionNos = [];
                                $averages = [];
                                while ($row = $result->fetch_assoc()) {
                                    $kuIds[] = $row["kuId"];
                                    $accessionNos[] = $row["รอบที่เข้าเรียน"];
                                    $averages[] = $row["AVG(fact2_grade_summary.gpa)"];
                                }
                                // แสดงตารางข้อมูลก่อนแผนภูมิ
                                echo "<h2>Data Table:</h2>";
                                echo "<div style='overflow-x:auto;'>";
                                echo "<table>
                                    <tr>
                                        <th>KU ID</th>
                                        <th>รอบที่เข้าเรียน</th>
                                        <th>Average GPA</th>
                                    </tr>";
                                for ($i = 0; $i < count($kuIds); $i++) {
                                    echo "<tr>
                                        <td>" . $kuIds[$i] . "</td>
                                        <td>" . $accessionNos[$i] . "</td>
                                        <td>" . $averages[$i] . "</td>
                                    </tr>";
                                }
                                echo "</table>";
                                echo "</div>";
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                            ?>

                            <!-- สร้างแผนภูมิแท่ง -->
                            <div style="width: 100%; margin: 20px auto;">
                                <canvas id="barChart"></canvas>
                            </div>

                            <script>
                                // กำหนดข้อมูลสำหรับแผนภูมิแท่ง
                                var accessionNos = <?php echo json_encode($accessionNos); ?>;
                                var kuIds = <?php echo json_encode($kuIds); ?>;
                                var averages = <?php echo json_encode($averages); ?>;

                                // สร้างออบเจ็กต์สำหรับเก็บสีของแต่ละปี
                                var yearColors = {};

                                // สร้างแผนภูมิแท่ง
                                var ctx = document.getElementById('barChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: accessionNos.map(function(accessionNo, index) {
                                            return accessionNo + ' (' + kuIds[index] + ')'; // เพิ่มรายละเอียด kuID ใน label
                                        }),
                                        datasets: [{
                                            label: 'Average GPA',
                                            data: averages,
                                            backgroundColor: accessionNos.map(function(accessionNo) {
                                                // ตรวจสอบว่ามีสีที่กำหนดไว้แล้วหรือไม่
                                                if (!(accessionNo in yearColors)) {
                                                    // สร้างสีสุ่มใหม่
                                                    var colors = ['rgba(255, 0, 0, 0.2)', 'rgba(0, 0, 255, 0.2)', 'rgba(0, 255, 0, 0.2)', 'rgba(255, 165, 0, 0.2)'];
                                                    var color = colors[Object.keys(yearColors).length % colors.length];
                                                    // บันทึกสีลงในออบเจ็กต์ yearColors
                                                    yearColors[accessionNo] = color;
                                                }
                                                // ส่งคืนสีที่มีอยู่หรือสร้างใหม่
                                                return yearColors[accessionNo];
                                            }),
                                            borderColor: accessionNos.map(function(accessionNo) {
                                                // ตรวจสอบว่ามีสีที่กำหนดไว้แล้วหรือไม่
                                                if (!(accessionNo in yearColors)) {
                                                    // สร้างสีสุ่มใหม่
                                                    var colors = ['rgba(255, 0, 0, 1)', 'rgba(0, 0, 255, 1)', 'rgba(0, 255, 0, 1)', 'rgba(255, 165, 0, 1)'];
                                                    var color = colors[Object.keys(yearColors).length % colors.length];
                                                    // บันทึกสีลงในออบเจ็กต์ yearColors
                                                    yearColors[accessionNo] = color;
                                                }
                                                // ส่งคืนสีที่มีอยู่หรือสร้างใหม่
                                                return yearColors[accessionNo];
                                            }),
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
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="plugins/common/common.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/gleek.js"></script>
    <script src="js/styleSwitcher.js"></script>

    <!-- Chartjs -->
    <script src="./plugins/chart.js/Chart.bundle.min.js"></script>
    <!-- Circle progress -->
    <script src="./plugins/circle-progress/circle-progress.min.js"></script>
    <!-- Datamap -->
    <script src="./plugins/d3v3/index.js"></script>
    <script src="./plugins/topojson/topojson.min.js"></script>
    <script src="./plugins/datamaps/datamaps.world.min.js"></script>
    <!-- Morrisjs -->
    <script src="./plugins/raphael/raphael.min.js"></script>
    <script src="./plugins/morris/morris.min.js"></script>
    <!-- Pignose Calender -->
    <script src="./plugins/moment/moment.min.js"></script>
    <script src="./plugins/pg-calendar/js/pignose.calendar.min.js"></script>
    <!-- ChartistJS -->
    <script src="./plugins/chartist/js/chartist.min.js"></script>
    <script src="./plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js"></script>

    <script src="./js/dashboard/dashboard-1.js"></script>

</body>

</html>
