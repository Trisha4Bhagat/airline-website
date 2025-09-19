<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $train_number = $_POST['train_number'];
    $departure_station = $_POST['departure_station'];
    $arrival_station = $_POST['arrival_station'];
    $departure_time = $_POST['departure_time'];
    $arrival_time = $_POST['arrival_time'];
    $price = $_POST['price'];
    $available_seats = $_POST['available_seats'];

    $sql = "INSERT INTO trains (Train_Number, Departure_Station, Arrival_Station, Departure_Time, Arrival_Time, Price, Available_Seats) 
            VALUES ('$train_number', '$departure_station', '$arrival_station', '$departure_time', '$arrival_time', '$price', '$available_seats')";

    if ($conn->query($sql) === TRUE) {
        echo "New train added successfully!";
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
    <title>Add Train</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Add New Train</h1>
        <nav>
            <a href="admin.php">Admin Panel</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main>
        <form method="post" action="add_train.php">
            <label for="train_number">Train Number:</label>
            <input type="text" name="train_number" id="train_number" required>

            <label for="departure_station">Departure Station:</label>
            <input type="text" name="departure_station" id="departure_station" required>

            <label for="arrival_station">Arrival Station:</label>
            <input type="text" name="arrival_station" id="arrival_station" required>

            <label for="departure_time">Departure Time:</label>
            <input type="datetime-local"
