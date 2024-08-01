<?php
include("connection.php");

if (isset($_GET['classID']) && isset($_GET['day'])) {
    $classID = $_GET['classID'];
    $day = $_GET['day'];

    $sql = "SELECT scheduleID, start_time, end_time FROM schedule WHERE classID = ? AND day = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $classID, $day);
    $stmt->execute();
    $stmt->bind_result($scheduleID, $start_time, $end_time);

    // Fetch the results
    $timeSlots = array();
    while ($stmt->fetch()) {
        $timeSlots[] = array(
            'scheduleID' => $scheduleID,
            'start_time' => $start_time,
            'end_time' => $end_time
        );
    }

    
    $stmt->close();

    // Convert the array to JSON and echo the result
    echo json_encode($timeSlots);
} else {
    // Handle the case where parameters are not set
    echo json_encode(array('error' => 'Parameters not set'));
}

mysqli_close($conn);
?>
