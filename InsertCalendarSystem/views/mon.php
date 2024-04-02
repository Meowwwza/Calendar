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
                            $sql = "SELECT semesterId, COUNT(*) AS count_students 
                                FROM fact1_grade 
                                WHERE gpaxAvg < 1.75 AND gpaxAvg >= 1.5 
                                GROUP BY semesterId";

                            $result = $conn->query($sql);

                            // ตรวจสอบว่ามีข้อมูลที่คิวรี่ได้หรือไม่
                            if ($result->num_rows > 0) {
                                // สร้างอาร์เรย์ของข้อมูลสำหรับแผนภูมิ
                                $semesterIds = [];
                                $studentCounts = [];
                                while ($row = $result->fetch_assoc()) {
                                    $semesterIds[] = $row["semesterId"];
                                    $studentCounts[] = $row["count_students"];
                                }
                                // แสดงตารางข้อมูลก่อนแผนภูมิ
                                echo "<h2>Data Table:</h2>";
                                echo "<table>
                                        <tr>
                                            <th>Semester ID</th>
                                            <th>Number of Students</th>
                                        </tr>";
                                for ($i = 0; $i < count($semesterIds); $i++) {
                                    echo "<tr>
                                            <td>" . $semesterIds[$i] . "</td>
                                            <td>" . $studentCounts[$i] . "</td>
                                        </tr>";
                                }
                                echo "</table>";
                            } else {
                                echo "0 results";
                            }
                            $conn->close();
                            ?>

                            <!-- สร้างแผนภูมิแท่ง -->
                            <div style="width: 50%; margin: 20px auto;">
                                <canvas id="barChart"></canvas>
                            </div>

                            <script>
                                // กำหนดข้อมูลสำหรับแผนภูมิแท่ง
                                var semesterIds = <?php echo json_encode($semesterIds); ?>;
                                var studentCounts = <?php echo json_encode($studentCounts); ?>;

                                // สร้างแผนภูมิแท่ง
                                var ctx = document.getElementById('barChart').getContext('2d');
                                var myChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: semesterIds,
                                        datasets: [{
                                            label: 'Number of Students',
                                            data: studentCounts,
                                            backgroundColor: 'rgba(54, 162, 235, 0.2)', // สีพื้นหลังแท่ง
                                            borderColor: 'rgba(54, 162, 235, 1)', // สีขอบแท่ง
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
        <!-- #/ container -->
    </div>
    <!--**********************************
            Content body end
        ***********************************-->


    <!--**********************************
            Footer start
        ***********************************-->

    <!--**********************************
            Footer end
        ***********************************-->
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

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