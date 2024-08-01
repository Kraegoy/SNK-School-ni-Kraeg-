<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];


    // Check if the username already exists in the database
    $checkQuery = "SELECT COUNT(*) AS count FROM account WHERE username = '$username'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult) {
        $row = $checkResult->fetch_assoc();
        $count = $row["count"];

        if ($count > 0) {
            echo "duplicate";
        } else {
            echo "not_duplicate";
        }
    } else {
        echo "error";
    }

    // Close the database connection
    $conn->close();
}
?>
