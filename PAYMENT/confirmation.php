<?php
// Retrieve the transaction details from the request
$transactionId = $_GET['TransID']; // Example: RKTQDM7W6S
$transactionAmount = $_GET['TransAmount']; // Example: 10

// Process the transaction and update your system accordingly
// You can perform database operations, send notifications, etc.

// Send a response back to Safaricom Daraja API confirming the status of the transaction
$response = array(
    'ResultCode' => '0',
    'ResultDesc' => 'Transaction processed successfully'
);

header('Content-Type: application/json');
echo json_encode($response);
?>
