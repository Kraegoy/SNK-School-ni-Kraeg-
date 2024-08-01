<?php
include 'template/header.php';

include("connection.php");

$userLevel = $_SESSION['userLevel'];
$accountID = $_SESSION['accountID'];
$username = $_SESSION['username'];
$userID = $_SESSION['userID'];

$classID = $_GET['classID'];
$day = $_GET['day'];
$scheduleID = $_GET['scheduleID'];

$maxMeetingQuery = "SELECT MAX(meetingNumber) AS maxMeeting FROM attendance WHERE scheduleID = '$scheduleID'";
$maxMeetingResult = mysqli_query($conn, $maxMeetingQuery);

$maxMeeting = 0;
if ($maxMeetingResult && mysqli_num_rows($maxMeetingResult) > 0) {
    $maxMeetingRow = mysqli_fetch_assoc($maxMeetingResult);
    $maxMeeting = $maxMeetingRow['maxMeeting'];
}

$query = "SELECT user_sched.userID, user.FirstName, user.MiddleName, user.LastName, attendance.meetingNumber, attendance.status, attendance.date
          FROM user_sched
          JOIN user ON user_sched.userID = user.userID
          LEFT JOIN attendance ON user_sched.userID = attendance.userID AND user_sched.scheduleID = attendance.scheduleID
          WHERE user_sched.scheduleID = '$scheduleID'";

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="vafc.css">

    <title>SNK</title>
</head>

<body>
<?php 
    if($userLevel == 1){
        include 'template/admin_nav.php';
    } else {
        include 'template/stud_nav.php';
    }
?>

<div class="main-content">
        <div class="awit">
            <div class="holder"><span>Attendance</span></div>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <?php
                    // Display TH for each meeting
                    for ($i = 1; $i <= $maxMeeting; $i++) {
                        $dateQuery = "SELECT date FROM attendance WHERE scheduleID = '$scheduleID' AND meetingNumber = $i LIMIT 1";
                        $dateResult = mysqli_query($conn, $dateQuery);
                        $date = ($dateResult && mysqli_num_rows($dateResult) > 0) ? date("Y-m-d", strtotime(mysqli_fetch_assoc($dateResult)['date'])) : '';
                        echo '<th>Meeting ' . $i . '<div class="date" style="font-size: 0.8em; color: #e52e71d3; margin-top: 10px;">' . $date . '</div></th>';
                    }
                    ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && mysqli_num_rows($result) > 0) {
                        // Initialize an array to store attendance status for each meeting
                        $attendanceStatus = array();
                        while ($row = mysqli_fetch_assoc($result)) {
                            $userID = $row['userID'];
                            $meetingNumber = $row['meetingNumber'];
                            $status = ($row['status']) ? $row['status'] : 'absent';
                        
                            $attendanceStatus[$userID][$meetingNumber] = $status;
                        }
                        
                        foreach ($attendanceStatus as $userID => $meetingStatus) {
                            // Fetch the user information for the current iteration
                            $query = "SELECT user_sched.userID, user.FirstName, user.MiddleName, user.LastName
                                      FROM user_sched
                                      JOIN user ON user_sched.userID = user.userID
                                      WHERE user_sched.userID = '$userID' AND user_sched.scheduleID = '$scheduleID'";
                            
                            $userResult = mysqli_query($conn, $query);
                            
                            if ($userResult && $userRow = mysqli_fetch_assoc($userResult)) {
                                echo '<tr>';
                                echo '<td>' . $userRow['FirstName'] . ' ' . $userRow['MiddleName'] . ' ' . $userRow['LastName'] . '</td>';
                        
                                // Display TD for each meeting
                                for ($i = 1; $i <= $maxMeeting; $i++) {
                                    $status = isset($meetingStatus[$i]) ? $meetingStatus[$i] : 'absent';
                                    $color = '';
                                    if($status == 'present'){
                                        $color = 'rgb(57, 255, 74)';
                                    }
                                    else if($status == 'late'){
                                        $color = 'rgb(57, 199, 255)';
                                    }else{
                                        $color = 'rgb(255, 74, 57)';
                                    }

                                    echo '<td style="color: ' . $color . '; opacity: 0.8;">' . $status . '</td>';
                                }
                        
                                echo '</tr>';
                            }
                        }
                        
                        
                        
                        
                    } else {
                        echo '<tr><td colspan="' . ($maxMeeting + 1) . '">No student yet for this class.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>


</body>
</html>
