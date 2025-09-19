


<?php
include 'db.php';
session_start(); // Start the session
$user_id = $_SESSION['user_id'];
// Check if the user is logged in
// if (!isset($_SESSION['user_id'])) {
//     // Redirect to login page if user is not logged in
//     header("Location: login.php");
//     exit();
// }
// Function to generate a random numeric booking ID with a specific number of digits
function generateRandomBookingId() {
    $length= 2;
    if ($length < 1 || $length > 4) {
        throw new Exception("Length must be between 1 and 4.");
    }

    // Define the range for the random number based on the number of digits
    $min = pow(10, $length - 1); // Minimum value for the specified number of digits
    $max = pow(10, $length) - 1; // Maximum value for the specified number of digits

    // Generate a random number within the range
    return random_int($min, $max);
}


// Retrieve the user ID from session
//$user_id = $_SESSION['user_id'];
// Check if the booking request is valid
if (isset($_GET['type']) && isset($_GET['flight_id'])) {
    $type = $_GET['type'];
    $ticket_id = $type === 'flight' ? $_GET['flight_id'] : $_GET['train_id'];
    $price = $_GET['price'];
    
    // Prepare to fetch flight or train details based on the type
    if ($type == 'flight') {
        $stmt = $conn->prepare("SELECT * FROM flights WHERE Flight_ID = ?");
    } else {
        $stmt = $conn->prepare("SELECT * FROM trains WHERE Train_ID = ?");
    }
    $stmt->bind_param("i", $ticket_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ticket_details = $result->fetch_assoc();
} else {
    // Redirect to the search page if the booking request is invalid
    header("Location: index.php");
    exit();
}

// Process the booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number_of_tickets = $_POST['number_of_tickets'];
    $total_amount = $price * $number_of_tickets;
    
    // Generate a random booking ID
    $booking_id = generateRandomBookingId(); // Example: BOOK6050e717f15a6
echo $booking_id;
echo $user_id;
    // Insert booking details into the database
    $stmt = $conn->prepare("INSERT INTO bookings (Booking_ID, User_ID, Travel_Type, Ticket_ID, Booking_Date, Number_Of_Tickets, Total_Amount) VALUES (?, ?, ?, ?, NOW(), ?, ?)");
    $stmt->bind_param("sisiis", $booking_id, $user_id, $type, $ticket_id, $number_of_tickets, $total_amount);
    $stmt->execute();

    // Redirect or display a success message
    echo "Booking successful! Booking ID: $booking_id, Total Amount: ₹$total_amount";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Booking Confirmation</h1>
    </header>

    <main>
        <h2><?php echo $type == 'flight' ? 'Flight Details' : 'Train Details'; ?></h2>
        <table>
            <tr>
                <th><?php echo $type == 'flight' ? 'Flight Number' : 'Train Number'; ?></th>
                <td><?php echo $ticket_details[$type == 'flight' ? 'Flight_Number' : 'Train_Number']; ?></td>
            </tr>
            <tr>
                <th>Departure</th>
                <td><?php echo $ticket_details[$type == 'flight' ? 'Departure_Airport' : 'Departure_Station']; ?></td>
            </tr>
            <tr>
                <th>Arrival</th>
                <td><?php echo $ticket_details[$type == 'flight' ? 'Arrival_Airport' : 'Arrival_Station']; ?></td>
            </tr>
            <tr>
                <th>Departure Time</th>
                <td><?php echo $ticket_details[$type == 'flight' ? 'Departure_Time' : 'Departure_Time']; ?></td>
            </tr>
            <tr>
                <th>Price</th>
                <td>₹<?php echo $price; ?></td>
            </tr>
        </table>

        <form method="post" action="booking.php?type=<?php echo $type; ?>&flight_id=<?php echo $ticket_id; ?>&price=<?php echo $price; ?>">
            <label for="number_of_tickets">Number of Tickets:</label>
            <input type="number" name="number_of_tickets" id="number_of_tickets" required min="1" max="10">

            <input type="submit" value="Confirm Booking">
        </form>
    </main>

    <footer>
        <p>© 2024 Airport Ticket Management System</p>
    </footer>
</body>
</html>
