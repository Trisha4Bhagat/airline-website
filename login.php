<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Create connection
    $conn = new mysqli('localhost', 'root', '', 'bookticket');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // "s" specifies the variable type => 'string'
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Debugging: echo the password and row password (can remove these in production)
        echo "Entered Password: " . htmlspecialchars($password) . "<br>";
        echo "Stored Password: " . htmlspecialchars($row['Password']) . "<br>"; // Adjust if column name is lowercase

        // Verify the password (assuming no password hashing; you should implement password hashing for security)
        if ($password === $row['Password']) { // Adjust the column name 'password' accordingly
            // Store email and user ID in session
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $row['User_ID']; // Store User_ID in session
            
            // Redirect to the homepage or another page
            header('Location: index.html');
            exit();
        } else {
            echo "<script>alert('Invalid login credentials');</script>";
        }
    } else {
        echo "<script>alert('Invalid login credentials');</script>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>
        <h1>Login</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="flights.php">Flights</a>
            <a href="trains.php">Trains</a>
            <a href="bookings.php">Bookings</a>
        </nav>
    </header>

    <main>
        <form action="login.php" method="POST">
            <label for="email">Email:</label><br>
            <input type="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>

        <p style="margin-top: 10px;">New user? <a href="register.php">Register here</a></p> <!-- Registration link below the form -->
    </main>

    <footer>
        <p>&copy; 2024 Ticket Management System</p>
    </footer>

</body>
</html>
