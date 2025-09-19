<?php
session_start();
include 'db.php'; // Database connection

// Check if user_id is provided in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Fetch bookings for the user
    $stmt = $conn->prepare("SELECT * FROM bookings WHERE User_ID = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display bookings
    echo "<h2>User Bookings</h2>";
    echo "<table>
            <tr>
                <th>Booking ID</th>
                <th>Travel Type</th>
                <th>Ticket ID</th>
                <th>Booking Date</th>
                <th>Number Of Tickets</th>
                <th>Total Amount</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['Booking_ID']}</td>
                <td>{$row['Travel_Type']}</td>
                <td>{$row['Ticket_ID']}</td>
                <td>{$row['Booking_Date']}</td>
                <td>{$row['Number_Of_Tickets']}</td>
                <td>{$row['Total_Amount']}</td>
              </tr>";
    }
    echo "</table>";

    $stmt->close();
} else {
    echo "No user ID provided.";
}

$conn->close();
?>
