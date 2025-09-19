<?php
session_start();

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header('Location: login.php');
//     exit();
// }

// Get the user's ID from the session
$user_id = $_SESSION['user_id'];
echo $user_id;

// Create connection
$conn = new mysqli('localhost', 'root', '', 'bookticket');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bookings for the logged-in user
$sql = "SELECT Booking_ID, Travel_Type, Ticket_ID, Booking_Date, Number_Of_Tickets, Total_Amount 
        FROM bookings 
        WHERE User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // "i" specifies the variable type => 'integer'
$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>My Bookings</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="flights.php">Flights</a>
            <a href="trains.php">Trains</a>
            <a href="mybookings.php">My Bookings</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Your Bookings</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Travel Type</th>
                        <th>Ticket ID</th>
                        <th>Booking Date</th>
                        <th>Number Of Tickets</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Booking_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Travel_Type']); ?></td>
                        <td><?php echo htmlspecialchars($row['Ticket_ID']); ?></td>
                        <td><?php echo htmlspecialchars($row['Booking_Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['Number_Of_Tickets']); ?></td>
                        <td><?php echo htmlspecialchars($row['Total_Amount']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </main>

    <footer>
        <p>&copy; 2024 Ticket Management System</p>
    </footer>

</body>
</html>

<?php
// Close the connection
$stmt->close();
$conn->close();
?>
