<?php
// Retrieve the transaction details from the request
$transactionId = $_GET['TransID']; // Example: RKTQDM7W6S
$transactionAmount = $_GET['TransAmount']; // Example: 10

// Perform validation checks on the transaction
// You can verify the transaction details, check if the amount is correct, etc.

// Send a response back to Safaricom Daraja API confirming the validation result
$response = array(
    'ResultCode' => '0',
    'ResultDesc' => 'Transaction validated successfully'
);

header('Content-Type: application/json');
echo json_encode($response);
?>
