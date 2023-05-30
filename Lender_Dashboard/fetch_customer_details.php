<?php
Require '../Functions/connect.php';

$selectedUniqueId = $_GET['unique_code'];
$stmt = $conn->prepare("SELECT * FROM agent_returns WHERE unique_code = ?");
$stmt->bind_param("s", $selectedUniqueId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$customerData = array(
    'agent_account_number' => $row['agent_account_number'],
    'commision' => $row['expected_commision'],
    'unique_code' => $row['unique_code']
);

$stmt->close();

// Return the customer details as JSON response
header('Content-Type: application/json');
echo json_encode($customerData);
?>
