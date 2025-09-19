<?php
include 'db.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $departure_date = $_POST['departure_date'];

    // Prepare and execute SQL query to search trains
    $stmt = $conn->prepare("SELECT * FROM trains WHERE Departure_Station = ? AND Arrival_Station = ? AND Departure_Time >= ?");
    $stmt->bind_param("sss", $departure_station, $arrival_station, $departure_date);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Search</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Search Trains</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="flights.php">Flights</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="post" action="trains.php">
            <label for="departure_station">Departure Station:</label>
            <input type="text" name="departure_station" id="departure_station" required>

            <label for="arrival_station">Arrival Station:</label>
            <input type="text" name="arrival_station" id="arrival_station" required>

            <label for="departure_date">Departure Date:</label>
            <input type="date" name="departure_date" id="departure_date" required>

            <input type="submit" value="Search Trains">
        </form>

        <?php if (isset($result)): ?>
            <h2>Available Trains</h2>
            <table>
                <thead>
                    <tr>
                        <th>Train Number</th>
                        <th>Departure Station</th>
                        <th>Arrival Station</th>
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
                            <td><?php echo $row['Train_Number']; ?></td>
                            <td><?php echo $row['Departure_Station']; ?></td>
                            <td><?php echo $row['Arrival_Station']; ?></td>
                            <td><?php echo $row['Departure_Time']; ?></td>
                            <td><?php echo $row['Arrival_Time']; ?></td>
                            <td><?php echo $row['Price']; ?></td>
                            <td><?php echo $row['Available_Seats']; ?></td>
                            <td>
                                <a href="booking.php?type=train&train_id=<?php echo $row['Train_ID']; ?>&price=<?php echo $row['Price']; ?>">Book Now</a>
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
