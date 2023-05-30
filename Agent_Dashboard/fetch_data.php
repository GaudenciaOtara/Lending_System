<?php
 Require '../Functions/connect.php';

$selectedValue = $_POST['selectedValue'];

$stmt = $conn->prepare("SELECT * FROM lender_transactions WHERE unique_code = ?");
$stmt->bind_param("s", $selectedValue);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();

   $data = array(
    'uniqueCode' => $row['unique_code'],
    'lenderID' => $row['lender_id'],
    'agentAccountNumber' => $row['agent_account_number']
  );

  header('Content-Type: application/json');
  $sumQuery = $conn->prepare("SELECT SUM(amount_sent) AS total_amount FROM customer_returns WHERE unique_code = ?");
  $sumQuery->bind_param("s", $selectedValue);
  $sumQuery->execute();
  $sumResult = $sumQuery->get_result();
  $sumData = $sumResult->fetch_assoc();
  
  $data['totalAmountSent'] = $sumData['total_amount'];

  echo json_encode($data);
} else {
  echo json_encode(array());
}
?>
