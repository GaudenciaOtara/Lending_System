<?php
include '../Functions/connect.php';

$selectedCustomerId = $_GET['id'];
$stmt = $conn->prepare("SELECT * from customer_money WHERE id = ?");
$stmt->bind_param("i", $selectedCustomerId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$customerData = array(
    'customerName' => $row['agent_id'],
    'customerEmail' => $row['total_amount'],
    'transactionCode'=>$row['unique_code'],
    'expectedInterest'=>$row['expected_interest']

);

$stmt->close();

// Return the customer details as JSON response
header('Content-Type: application/json');
echo json_encode($customerData);
?>
