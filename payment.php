<?php
include 'db.php';

session_start();

use Razorpay\Api\Api;

$user_id = $_SESSION['user_id'];
$type = $_GET['type'];
$ticket_id = $_GET['ticket_id'];
$price = $_GET['price'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number_of_tickets = $_POST['number_of_tickets'];
    $total_amount = $price * $number_of_tickets;
    $_SESSION['total_amount'] = $total_amount;

    // Initialize Razorpay API
    $api = new Api('rzp_test_6IPcXJa9FZrABX', '81tgSewAhQ6GP0st7lbqqAtl');

    // Create an order in Razorpay
    $orderData = [
        'receipt'         => 'order_rcptid_' . time(),
        'amount'          => $total_amount * 100, // Amount in paisa
        'currency'        => 'INR',
        'payment_capture' => 1 // Auto-capture
    ];

    $razorpayOrder = $api->order->create($orderData);
    $_SESSION['razorpay_order_id'] = $razorpayOrder['id'];
    $_SESSION['number_of_tickets'] = $number_of_tickets;
    $_SESSION['ticket_id'] = $ticket_id;
    $_SESSION['type'] = $type;
    $_SESSION['total_amount']=$number_of_tickets*$price;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
</head>
<body>
    <header>
        <h1>Make Payment</h1>
    </header>

    <main>
        <button id="rzp-button">Pay ₹<?php echo $_SESSION['total_amount']; ?></button>
    </main>

    <script>
        var options = {
            "key": "rzp_test_6IPcXJa9FZrABX", // Razorpay API key
            "amount": "<?php echo $_SESSION['total_amount'] * 100; ?>", // Amount in paisa
            "currency": "INR",
            "name": "Ticket Booking System",
            "description": "Ticket Booking Payment",
            "order_id": "<?php echo $_SESSION['razorpay_order_id']; ?>", 
            "handler": function (response) {
                // Handle payment success and redirect to success page
                window.location.href = "payment_success.php?razorpay_payment_id=" + response.razorpay_payment_id;
            },
            "prefill": {
                "name": "<?php echo $_SESSION['user_name']; ?>",
                "email": "<?php echo $_SESSION['user_email']; ?>"
            },
            "theme": {
                "color": "#F37254"
            }
        };

        var rzp1 = new Razorpay(options);
        document.getElementById('rzp-button').onclick = function(e) {
           
