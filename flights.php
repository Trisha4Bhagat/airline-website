<?php
include 'db.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure_location = $_POST['departure_location'];
    $arrival_location = $_POST['arrival_location'];
    $departure_date = $_POST['departure_date'];

    // Prepare and execute SQL query to search flights
    $stmt = $conn->prepare("SELECT * FROM flights WHERE Departure_Airport = ? AND Arrival_Airport = ? AND Departure_Time >= ?");
    $stmt->bind_param("sss", $departure_location, $arrival_location, $departure_date);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Search Flights</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="trains.php">Trains</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="post" action="flights.php">
            <label for="departure_location">Departure Location:</label>
            <input type="text" name="departure_location" id="departure_location" required>

            <label for="arrival_location">Arrival Location:</label>
            <input type="text" name="arrival_location" id="arrival_location" required>

            <label for="departure_date">Departure Date:</label>
            <input type="date" name="departure_date" id="departure_date" required>

            <input type="submit" value="Search Flights">
        </form>

        <?php if (isset($result)): ?>
            <h2>Available Flights</h2>
            <table>
                <thead>
                    <tr>
                        <th>Flight Number</th>
                        <th>Departure Airport</th>
                        <th>Arrival Airport</th>
                        <th>Departure Time</th>
                        <th>Arrival Time</th>
                        <th>Price</th>
                        <th>Available Seats</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['Flight_Number']; ?></td>
                            <td><?php echo $row['Departure_Airport']; ?></td>
                            <td><?php echo $row['Arrival_Airport']; ?></td>
                            <td><?php echo $row['Departure_Time']; ?></td>
                            <td><?php echo $row['Arrival_Time']; ?></td>
                            <td><?php echo $row['Price']; ?></td>
                            <td><?php echo $row['Available_Seats']; ?></td>
                            <td>
                                <a href="booking.php?type=flight&flight_id=<?php echo $row['Flight_ID']; ?>&price=<?php echo $row['Price']; ?>">Book Now</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2024 Airport Ticket Management System</p>
    </footer>
</body>
</html>
