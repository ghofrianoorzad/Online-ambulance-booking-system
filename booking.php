<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ambulance_type = $_POST["ambulance_type"];
    $location = $_POST["location"];
    $user = $_SESSION['username'];

    $query = $connection->prepare("INSERT INTO bookings (username, ambulance_type, location) VALUES (?, ?, ?)");
    $query->bind_param("sss", $user, $ambulance_type, $location);
    if ($query->execute()) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $query->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book an Ambulance</title>
</head>
<body>
    <h1>Book an Ambulance</h1>
    <form action="booking.php" method="POST">
        <select name="ambulance_type" required>
            <option value="">Select Ambulance Type</option>
            <option value="Basic">Basic</option>
            <option value="Advanced">Advanced</option>
        </select>
        <input type="text" name="location" placeholder="Location" required>
        <input type="submit" value="Book">
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
