<?php
session_start();

include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $classID = $_POST['classID'];
    $day = $_POST['day'];
    $userID = $_POST['userID'];
    $start_time = $_POST['start_time']; 
    $end_time = $_POST['end_time']; 

    $sqlSchedule = "SELECT scheduleID FROM schedule WHERE classID = ? AND day = ? AND start_time = ? AND end_time = ?";
    $stmtSchedule = $conn->prepare($sqlSchedule);
    $stmtSchedule->bind_param("isss", $classID, $day, $start_time, $end_time);
    $stmtSchedule->execute();
    $stmtSchedule->bind_result($scheduleID);
    $stmtSchedule->fetch();
    $stmtSchedule->close();

    // Insert data into user_sched
    $sqlInsert = "INSERT INTO user_sched (userID, classID, scheduleID) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("iii", $userID, $classID, $scheduleID);

    // Execute the statement
    if ($stmtInsert->execute()) {
        echo "<script>
        alert('Added Successfully!');
        window.location.href = 'display_users.php'; 
    </script>";
        exit();
    } else {
        echo "Error: " . $stmtInsert->error;
    }

    $stmtInsert->close();
}

mysqli_close($conn);
?>
