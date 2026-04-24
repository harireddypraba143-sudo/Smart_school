<?php
define('BASEPATH', 1);
require 'application/config/database.php';
$conn = new mysqli($db['default']['hostname'], $db['default']['username'], $db['default']['password'], $db['default']['database']);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }
$result = $conn->query("SELECT * FROM club");
while($row = $result->fetch_assoc()) { print_r($row); }
$conn->close();
?>
