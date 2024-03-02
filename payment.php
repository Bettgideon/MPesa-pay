<?php
// M-Pesa API credentials
$consumerKey = 'safaricom';
$consumerSecret = 'root';
$shortcode = '0790729721'; // This is your M-Pesa Paybill or Buy Goods Till Number

// Database connection credentials
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mpesa_payments";

// Extract amount and PIN from the request
$data = json_decode(file_get_contents("php://input"), true);
$amount = $data['amount'];
$pin = $data['pin'];

// Validate the amount
if ($amount < 200) {
    $response = array('success' => false, 'error' => 'Invalid amount.');
    http_response_code(400);
    echo json_encode($response);
    exit;
}

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    $response = array('success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error);
    http_response_code(500);
    echo json_encode($response);
    exit;
}

// Prepare and execute SQL statement to insert payment record
$stmt = $conn->prepare("INSERT INTO payments (amount) VALUES (?)");
$stmt->bind_param("d", $amount);
if ($stmt->execute()) {
    // Payment successfully recorded in the database

    // Here you would call M-Pesa's API to initiate the payment process
    // For demonstration purposes, we'll simulate a successful payment
    $response = array('success' => true);
    echo json_encode($response);
} else {
    // Error occurred while recording payment in the database
    $response = array('success' => false, 'error' => 'Failed to record payment: ' . $conn->error);
    http_response_code(500);
    echo json_encode($response);
}

// Close database connection
$stmt->close();
$conn->close();
?>
