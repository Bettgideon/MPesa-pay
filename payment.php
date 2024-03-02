<?php
// Get the amount and PIN from the POST request
$data = json_decode(file_get_contents("php://input"), true);
$amount = $data['amount'];
$pin = $data['pin'];

// Here you would use M-Pesa's API to initiate the payment
// This part would require integration with M-Pesa's API.
// Replace the following lines with actual code to interact with M-Pesa API
// Simulating success for demonstration purposes
$response = array('success' => true);

// Send response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>
