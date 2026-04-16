<?php
$conn = new mysqli('localhost', 'root', '', 'school');
if ($conn->connect_error) { die("Connection failed"); }
$conn->query("ALTER TABLE teacher ADD COLUMN joining_salary decimal(10,2) DEFAULT '0.00'");
$conn->query("ALTER TABLE teacher ADD COLUMN date_of_joining date DEFAULT NULL");
echo "Done";
?>
