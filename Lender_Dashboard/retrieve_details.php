<?php
include '../Functions/connect.php';

$selectedValue = $_GET['selectedValue'];

$stmt = $conn->prepare("SELECT * FROM agent_returns WHERE unique_code = ?");
$stmt->bind_param("s", $selectedValue);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $detailsHTML = '<h3>Details:</h3>';
  $detailsHTML .= '<p>Total Amount: ' . $row['total_amount'] . '</p>';
  $detailsHTML .= '<p>Agent Account Number: ' . $row['agent_account_number'] . '</p>';
} else {
  $detailsHTML = '<p>No details found for the selected value.</p>';
}

echo $detailsHTML;
?>
