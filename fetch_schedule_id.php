<?php
include("connection.php");

$classID = $_GET['classID'];
$day = $_GET['day'];
$timeSlotID = $_GET['timeSlot'];

$sql = "SELECT scheduleID FROM schedule WHERE classID = ? AND day = ? AND scheduleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $classID, $day, $timeSlotID);
$stmt->execute();
$stmt->bind_result($scheduleID);
$stmt->fetch();
$stmt->close();

echo json_encode(['scheduleID' => $scheduleID]);

mysqli_close($conn);
?>
