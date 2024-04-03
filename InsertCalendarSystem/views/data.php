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
header('Content-Type: application/json');
echo json_encode($data);
?>
