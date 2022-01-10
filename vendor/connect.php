<?php
DEFINE('DB_USERNAME', 'mamadmin');
DEFINE('DB_PASSWORD', 'N1so5@21');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_DATABASE', 'notary');

// Create connection
$conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn->connect_error) {
  die("Connection failed<br>: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");
//echo "Connected successfully<br>";




?>