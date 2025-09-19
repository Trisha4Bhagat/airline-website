<?php
include 'db.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM flights WHERE Flight_ID = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error deleting flight: " . $conn->error;
    }
}
?>
