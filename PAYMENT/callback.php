<?php

// Retrieve the request payload from MPESA
$requestPayload = file_get_contents('php://input');

// Log the request payload for debugging (optional)
file_put_contents('callback.log', $requestPayload . PHP_EOL, FILE_APPEND);

// Process the request payload
$data = json_decode($requestPayload);

// Check if the request payload is valid
if ($data && isset($data->Body) && isset($data->Body->stkCallback)) {
    // Retrieve the important data from the request payload
    $resultCode = $data->Body->stkCallback->ResultCode;
    $checkoutRequestId = $data->Body->stkCallback->CheckoutRequestID;
    $resultCode = $data->Body->stkCallback->ResultCode;

    // Perform necessary actions based on the result code
    if ($resultCode == 0) {
        // Payment was successful
        // Perform any post-payment actions here

        // Log the successful payment for further processing or record-keeping (optional)
        file_put_contents('payments.log', 'Successful Payment: ' . $checkoutRequestId . PHP_EOL, FILE_APPEND);
    } else {
        // Payment was not successful
        // Perform any error handling or logging here

        // Log the failed payment for further processing or record-keeping (optional)
        file_put_contents('payments.log', 'Failed Payment: ' . $checkoutRequestId . PHP_EOL, FILE_APPEND);
    }
} else {
    // Invalid request payload
    // Log the invalid request for debugging or error handling (optional)
    file_put_contents('callback.log', 'Invalid Request Payload' . PHP_EOL, FILE_APPEND);
}

// Send a response to MPESA to acknowledge the callback
$response = array(
    'ResultCode' => 0,
    'ResultDesc' => 'Callback received successfully'
);

header('Content-Type: application/json');
echo json_encode($response);
?>