<?php
session_start();
$userID = $_SESSION['userID'];

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $day = $_POST['day'];
    $classID = $_POST['classID'];


    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO schedule (classID, start_time, end_time, day) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $classID, $start_time, $end_time, $day);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            alert('Added Successfully!');
            </script>";
            header("Location: ".$_SERVER['HTTP_REFERER']);

        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
}

mysqli_close($conn);
?>
