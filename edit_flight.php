<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM flights WHERE Flight_ID = $id");
    $flight = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $flight_number = $_POST['flight_number'];
    $departure_airport = $_POST['departure_airport'];
    $arrival_airport = $_POST['arrival_airport'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];

    $sql = "UPDATE flights SET 
            Flight_Number='$flight_number',
            Departure_Airport='$departure_airport',
            Arrival_Airport='$arrival_airport',
            Departure_Time='$departure_time',
            Arrival_Time='$arrival_time',
            Price='$price',
            Available_Seats='$available_seats'
            WHERE Flight_ID = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Flight updated successfully!";
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
    <title>Edit Flight</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Edit Flight</h1>
        <nav>
            <a href="admin.php">Admin Panel</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="post" action="edit_flight.php?id=<?php echo $id; ?>">
            <label for="flight_number">Flight Number:</label>
            <input type="text" name="flight_number" id="flight_number" value="<?php echo $flight['Flight_Number']; ?>" required>

            <label for="departure_airport">Departure Airport:</label>
            <input type="text" name="departure_airport" id="departure_airport" value="<?php echo $flight['Departure_Airport']; ?>" required>

            <label for="arrival_airport">Arrival Airport:</label>
            <input type="text" name="arrival_airport" id="arrival_airport" value="<?php echo $flight['Arrival_Airport']; ?>" required>

            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local" name="departure_time" id="departure_time" value="<?php echo $flight['Departure_Time']; ?>" required>

            <label for="arrival_time">Arrival Time:</label>
            <input type="datetime-local" name="arrival_time" id="arrival_time" value="<?php echo $flight['Arrival_Time']; ?>" required>

            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo $flight['Price']; ?>" required>

            <label for="available_seats">Available Seats:</label>
            <input type="number" name="available_seats" id="available_seats" value="<?php echo $flight['Available_Seats']; ?>" required>

            <input type="submit" value="Update Flight">
        </form>
    </main>

    <footer>
        <p>© 2024 Airport Ticket Management System</p>
    </footer>
</body>
</html>
