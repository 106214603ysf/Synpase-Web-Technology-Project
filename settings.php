<?php
$host = "localhost";
$user = "root";
$pwd = "";
$sql_db = "synapse_db";

$conn = mysqli_connect($host, $user, $pwd, $sql_db);
if ($conn) {
    mysqli_set_charset($conn, "utf8mb4");
}
?>