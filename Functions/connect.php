<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "1234";
$databasename = "lending_system";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $databasename);

if (!$conn) {

    die();

}

?>