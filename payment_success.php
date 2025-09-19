<?php
include 'db.php';
session_start();

if (isset($_GET['razorpay_payment_id']) && isset($_SESSION['razorpay_order_id'])) {
    $razorpay_payment_id = $_GET['razorpay_payment_id'];
    $user_id = $_SESSION['user_id'];
    $type = $_SESSION['type'];
    $ticket_id = $_SESSION['ticket_id'];
    $number_of_tickets = $_SESSION['number_of_tickets'];
    $total_amount = $_SESSION['total_amount'];

    // Generate a random booking ID
    $booking_id = 'BOOK' . time(); // Example: BOOK163456789

    // Insert booking details into the database
    $stmt = $conn->prepare("INSERT INTO bookings (Booking_ID, User_ID, Travel_Type, Ticket_ID, Booking_Date, Number_Of_Tickets, Total_Amount) VALUES (?, ?, ?, ?, NOW(), ?, ?)");
    $stmt->bind_param("sisiis", $booking_id, $user_id, $type, $ticket_id, $number_of_tickets, $total_amount);
    $stmt->execute();

    // Clear session variables related to booking
    unset($_SESSION['razorpay_order_id']);
    unset($_SESSION['ticket_id']);
    unset($_SESSION['type']);
    unset($_SESSION['number_of_tickets']);
    unset($_SESSION['total_amount']);

    // Display success message
    echo "Booking successful! Booking I
