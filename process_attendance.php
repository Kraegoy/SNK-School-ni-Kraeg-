<?php
include("connection.php");
date_default_timezone_set('Asia/Manila');

$classID = $_POST['classID'];
$className = $_POST['className'];
// Check if the form is submitted
if (isset($_POST['attendButton'])) {
    // Get user ID and schedule ID from the form submission
    $userID = $_POST['userID'];
    $scheduleID = $_POST['scheduleID'];
    $start_time=$_POST['start_time'];
   // Check if the user is late based on the current time and start time
        $currentTime = time();
        $lateThreshold = strtotime($start_time) + (30 * 60); // 30 minutes in seconds
        $isLate = ($currentTime > $lateThreshold);
        $status = ($isLate) ? 'late' : 'present';



    // Check if there is any previous attendance record for today
    $checkQuery = "SELECT * FROM attendance WHERE userID = '$userID' AND scheduleID = '$scheduleID' AND date = CURDATE() ORDER BY attendanceID DESC LIMIT 1";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $lastMeetingNumberQuery = "SELECT MAX(meetingNumber) AS lastMeetingNumber FROM attendance WHERE userID = '$userID' AND scheduleID = '$scheduleID'";
        $lastMeetingNumberResult = mysqli_query($conn, $lastMeetingNumberQuery);
        $lastMeetingNumberRow = mysqli_fetch_assoc($lastMeetingNumberResult);
        $lastMeetingNumber = $lastMeetingNumberRow['lastMeetingNumber'];

        // If meeting number is null, set it to 1, otherwise use the current value
        $meetingNumber = ($lastMeetingNumber === null) ? 1 : $lastMeetingNumber;
    } else {
        $lastMeetingNumberQuery = "SELECT MAX(meetingNumber) AS lastMeetingNumber FROM attendance WHERE userID = '$userID' AND scheduleID = '$scheduleID'";
        $lastMeetingNumberResult = mysqli_query($conn, $lastMeetingNumberQuery);
        $lastMeetingNumberRow = mysqli_fetch_assoc($lastMeetingNumberResult);
        $lastMeetingNumber = $lastMeetingNumberRow['lastMeetingNumber'];

        // If meeting number is null, set it to 1, otherwise increment it
        $meetingNumber = ($lastMeetingNumber === null) ? 1 : ($lastMeetingNumber + 1);

        // Perform the database insertion
        $insertQuery = "INSERT INTO attendance (userID, scheduleID, date, meetingNumber, status) VALUES ('$userID', '$scheduleID', CURDATE(), '$meetingNumber', '$status')";
        $insertResult = mysqli_query($conn, $insertQuery);
    }
}

// Concatenate values directly into the URL in the header location
header("Location: view_room.php?classID=$classID&className=$className&userID=$userID&scheduleID=$scheduleID&date=" . urlencode(date('Y-m-d')) . "&meetingNumber=$meetingNumber&status=present");
exit();
?>
