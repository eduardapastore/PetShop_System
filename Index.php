<?php
include 'processa.php';
$conn = OpenCon();
if ($conn instanceof mysqli) {
echo "Connected Successfully using MySQLi";
} else {
echo "Unexpected connection type.";
}
CloseCon($conn);
?>


