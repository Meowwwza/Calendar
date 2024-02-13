<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
include('connection_connect.php');

// Delete all records from the 'date' table
$deleteQuery = "DELETE FROM date";

if ($conn->query($deleteQuery) === TRUE) {
    echo "All records deleted successfully.";
} else {
    echo "Error deleting records: " . $conn->error;
}

// Close the database connection
include('connection_close.php');

echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ลบข้อมูลทั้งหมดเรียบร้อย',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
            </script>";

header("refresh:2; url=../views/deleteAll.php");

?>
