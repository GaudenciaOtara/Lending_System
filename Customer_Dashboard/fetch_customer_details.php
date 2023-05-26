<?php
include '../Functions/connect.php';

$selectedCustomerId = $_GET['id'];
$stmt = $conn->prepare("SELECT * from customer_money WHERE id = ?");
$stmt->bind_param("i", $selectedCustomerId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo "Customer Name: " . $row['customer_name'] . "<br>";
echo "Customer Email: " . $row['customer_email'] . "<br>";

$stmt->close();
?>
