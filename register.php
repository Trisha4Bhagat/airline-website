<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        // Create connection
        $conn = new mysqli('localhost', 'root', '', 'bookticket');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($checkEmail);

        if ($result->num_rows > 0) {
            echo "<script>alert('Email already exists');</script>";
        } else {
            // Generate a random 4-digit user ID
            $user_id = mt_rand(1000, 9999);

            // Prepare and bind
            $stmt = $conn->prepare("INSERT INTO users (User_Id, name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $user_id, $name, $email, $password);

            // Execute the statement
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful. You can now log in.');</script>";
                header('Location: login.php');
                exit();
            } else {
                echo "<script>alert('Error: " . $stmt->error . "');</script>";
            }
        }

        // Close the connection
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Register</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="flights.php">Flights</a>
            <a href="trains.php">Trains</a>
            <a href="bookings.php">Bookings</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>
        <form action="register.php" method="POST">
            <label for="name">Name:</label><br>
            <input type="text" name="name" required><br>
            <label for="email">Email:</label><br>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br>
            <label for="confirm_password">Confirm Password:</label><br>
            <input type="password" name="confirm_password" required><br><br>
            <input type="submit" value="Register">
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Ticket Management System</p>
    </footer>

</body>
</html>
