<?php
// Start session and ensure the user is an admin
session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
//     header("Location: login.php");
//     exit();
// }

include 'db.php'; // Include database connection

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Manage Flights</h2>
        <table>
            <tr>
                <th>Flight Number</th>
                <th>Departure Airport</th>
                <th>Arrival Airport</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
                <th>Seats Available</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM flights");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Flight_Number']}</td>
                        <td>{$row['Departure_Airport']}</td>
                        <td>{$row['Arrival_Airport']}</td>
                        <td>{$row['Departure_Time']}</td>
                        <td>{$row['Arrival_Time']}</td>
                        <td>{$row['Price']}</td>
                        <td>{$row['Available_Seats']}</td>
                        <td>
                            <a href='edit_flight.php?id={$row['Flight_ID']}'>Edit</a> | 
                            <a href='delete_flight.php?id={$row['Flight_ID']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
        <a href="add_flight.php">Add New Flight</a>

        <h2>Manage Trains</h2>
        <table>
            <tr>
                <th>Train Number</th>
                <th>Departure Station</th>
                <th>Arrival Station</th>
                <th>Departure Time</th>
                <th>Arrival Time</th>
                <th>Price</th>
                <th>Seats Available</th>
                <th>Actions</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM trains");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['Train_Number']}</td>
                        <td>{$row['Departure_Station']}</td>
                        <td>{$row['Arrival_Station']}</td>
                        <td>{$row['Departure_Time']}</td>
                        <td>{$row['Arrival_Time']}</td>
                        <td>{$row['Price']}</td>
                        <td>{$row['Available_Seats']}</td>
                        <td>
                            <a href='edit_train.php?id={$row['Train_ID']}'>Edit</a> | 
                            <a href='delete_train.php?id={$row['Train_ID']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </table>
        <a href="add_train.php">Add New Train</a>

        <h2>Manage Users</h2>
<table>
    <tr>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Role</th>
        <th>Actions</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM users");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['User_ID']}</td>
                <td>{$row['Name']}</td>
                <td>{$row['Email']}</td>
                <td>{$row['Phone_Number']}</td>
                <td>{$row['Role']}</td>
                <td>
                    <a href='edit_user.php?id={$row['User_ID']}'>Edit</a> | 
                    <a href='delete_user.php?id={$row['User_ID']}' onclick='return confirm(\"Are you sure?\")'>Delete</a> | 
                    <a href='adminbook.php?user_id={$row['User_ID']}'>Bookings</a>
                </td>
              </tr>";
    }
    ?>
</table>
<a href="add_user.php">Add New User</a>

    </main>

    <footer>
        <p>© 2024 Airport Ticket Management System</p>
    </footer>
</body>
</html>
