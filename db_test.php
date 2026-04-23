<?php
$mysqli = new mysqli("localhost", "root", "", "smart_school");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
$res = $mysqli->query("DESCRIBE teacher");
while ($row = $res->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}
?>
