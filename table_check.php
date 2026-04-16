<?php
$conn = new mysqli('localhost', 'root', '', 'school');
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$result = $conn->query("SHOW TABLES");
if (!$result) { die("Query failed: " . $conn->error); }
while ($row = $result->fetch_array()) { echo $row[0] . "\n"; }
?>
