<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_airport = $_POST['departure_airport'];
    $arrival_airport = $_POST['arrival_airport'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];

    $sql = "INSERT INTO flights (Flight_Number, Departure_Airport, Arrival_Airport, Departure_Time, Arrival_Time, Price, Available_Seats) 
            VALUES ('$flight_number', '$departure_airport', '$arrival_airport', '$departure_time', '$arrival_time', '$price', '$available_seats')";

    if ($conn->query($sql) === TRUE) {
        echo "New flight added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Flight</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Add New Flight</h1>
        <nav>
            <a href="admin.php">Admin Panel</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="post" action="add_flight.php">
            <label for="flight_number">Flight Number:</label>
            <input type="text" name="flight_number" id="flight_number" required>

            <label for="departure_airport">Departure Airport:</label>
            <input type="text" name="departure_airport" id="departure_airport" required>

            <label for="arrival_airport">Arrival Airport:</label>
            <input type="text" name="arrival_airport" id="arrival_airport" required>

            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" name="departure_time" id="departure_time" required>

            <label for="arrival_time">Arrival Time:</label>
            <input type="datetime-local" name="arrival_time" id="arrival_time" required>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" required>

            <label for="available_seats">Available Seats:</label>
            <input type="number" name="available_seats" id="available_seats" required>

            <input type="submit" value="Add Flight">
        </form>
    </main>

    <footer>
        <p>© 2024 Airport Ticket Management System</p>
    </footer>
</body>
</html>
